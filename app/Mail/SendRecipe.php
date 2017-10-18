<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Recipe;

class SendRecipe extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Recipe $recipe
     */
    protected $recipe;

    /**
     * Recipe constructor.
     * @param \App\Models\Recipe $recipe
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recipe: '.$this->recipe->title)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('recipe.share.email')
            ->with([
                'recipe' => $this->recipe
            ]);
    }
}
