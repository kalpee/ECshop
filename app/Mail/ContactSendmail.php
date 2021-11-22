<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $email;
    private $title;
    private $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $inputs )
    {
        $this->name = $inputs['name'];
        $this->email = $inputs['email'];
        $this->title = $inputs['title'];
        $this->contact  = $inputs['contact'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('shogo.galleria.game@gmail.com')
            ->subject('自動送信メール')
            ->view('user.contact.mail')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'title' => $this->title,
                'contact'  => $this->contact,
            ]);
    }
}
