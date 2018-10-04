<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMail;
use App\Http\Requests\ContactoRequest;
use App\Contacto;


class ContactoController extends Controller
{

    public function read()
    {

        return view('contacto');
    }

    public function send(ContactoRequest $request)
    {

        $contact = new Contacto();
        $contact->nombre = request('nombre');
        $contact->email = request('email');
        $contact->body = request('cuerpo');
        $contact->phone = request('phone');
        $contact->ip = request()->ip();
        //$contact->store('Se ha guardado correctamente');

        $myMail = new ContactoMail();
        $myMail->mail = $contact;
        \MailHelper::enviar($myMail);

        return redirect()->route('contacto');
    }
}