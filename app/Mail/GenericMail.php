<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
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
     * Email Genérico para construir en controladores.
     *
     * @param $emailDestino
     * @param $nombreDestinatario
     * @param $titulo
     * @param $vista
     * @param $datos
     * @return GenericMail
     */
    public function build($emailDestino, $nombreDestinatario, $titulo, $vista, $datos)
    {
        return $this->view($vista, $datos)
            ->to($emailDestino, $nombreDestinatario)
            ->subject($titulo)
            ->from(config('_xerintel.app_mail'), config('_xerintel.app_mail_name'));
    }
}
