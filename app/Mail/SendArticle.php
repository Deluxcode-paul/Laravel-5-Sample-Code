<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Article;

class SendArticle extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Article $article
     */
    protected $article;

    /**
     * Article constructor.
     * @param \App\Mail\Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Article: '.$this->article->title)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('pages.lifestyle.article.share.email')
            ->with([
                'article' => $this->article
            ]);
    }
}
