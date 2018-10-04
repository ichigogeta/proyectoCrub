<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.mail_contacto', ['mail' => $this->mail])
            ->to(config('_xerintel.mail_cliente'), 'Admin')
            ->subject('Ha recibido un mensaje de contacto.')
            ->from(config('_xerintel.app_mail'), config('_xerintel.app_mail_name'));
    }
}
