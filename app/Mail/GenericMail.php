<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos, $vista, $emailDestino, $nombreDestinatario, $titulo;

    /**
     * Create a new message instance.
     *
     * @param $emailDestino
     * @param $nombreDestinatario
     * @param $titulo
     * @param $vista
     * @param $datos
     * @return void
     */
    public function __construct($emailDestino, $nombreDestinatario, $titulo, $vista, $datos = null)
    {
        $this->datos = $datos;
        $this->titulo = $titulo;
        $this->vista = $vista;
        $this->emailDestino = $emailDestino;
        $this->nombreDestinatario = $nombreDestinatario;
    }

    /**
     * Email Genérico para construir en controladores.
     * @return GenericMail
     */
    public function build()
    {
        return $this->view($this->vista, $this->datos)
            ->to($this->emailDestino, $this->nombreDestinatario)
            ->subject($this->titulo)
            ->from(config('_xerintel.app_mail'), config('_xerintel.app_mail_name'));
    }
}
