<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class PostPublishedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $post;

    /**
     * Create a new message instance.
     */
    //public function __construct()
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('New Post Published: ' . $this->post->title)
                    ->markdown('emails.posts.published');
    }
}
