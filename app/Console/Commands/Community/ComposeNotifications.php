<?php

namespace App\Console\Commands\Community;

use App\Mail\CommunityNotification;
use App\Models\CommunityNotificationReply;
use App\Models\CommunityNotificationTag;
use App\Models\CommunityNotificationUpdate;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ComposeNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'community:compose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compose community notifications';

    /**
     * @var
     */
    protected $users;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getUsers();
        $this->compose();

        $this->info('Notifications composed and queued.');
    }

    /**
     * Get all users for notification
     */
    protected function getUsers()
    {
        $users = collect();

        $tagUsers    = CommunityNotificationTag::select('user_id')->distinct()->pluck('user_id');
        $replyUsers  = CommunityNotificationReply::select('user_id')->distinct()->pluck('user_id');
        $updateUsers = CommunityNotificationUpdate::select('user_id')->distinct()->pluck('user_id');

        $this->users = $users->merge($tagUsers)->merge($replyUsers)->merge($updateUsers)->unique()->sort();
    }

    /**
     * Compose emails
     */
    protected function compose()
    {
        foreach ($this->users as $user_id) {
            $user = User::find($user_id);

            if ($user->isNotifiable()) {
                $_tags    = collect();
                $_replies = collect();
                $_updates = collect();

                $tags    = CommunityNotificationTag::where('user_id', $user_id)->get();
                $replies = CommunityNotificationReply::where('user_id', $user_id)->get();
                $updates = CommunityNotificationUpdate::where('user_id', $user_id)->get();

                foreach ($tags as $tag) {
                    if ($tag->post) {
                        $_tags->push($tag->post);
                    }
                }
                foreach ($replies as $reply) {
                    if ($reply->reply) {
                        $_replies->push($reply->reply);
                    }
                }
                foreach ($updates as $update) {
                    if ($update->reply) {
                        $_updates->push($update->reply);
                    }
                }

                Mail::to($user->email)->queue(new CommunityNotification($_tags, $_replies, $_updates));
            }

            CommunityNotificationTag::where('user_id', $user_id)->delete();
            CommunityNotificationReply::where('user_id', $user_id)->delete();
            CommunityNotificationUpdate::where('user_id', $user_id)->delete();
        }
    }
}
