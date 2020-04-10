@extends('mail.layouts.master')

@section('content')
    <div>
        Hola, has sido contactado por: {{$mail->nombre}}<br>
        Datos del contacto:
        <div>
            <p>
                Email: <a href="mailto:{{ $mail->email }}">{{ $mail->email }}</a>
            </p>
            <p>
                Telefono: {{ $mail->phone }}
            </p>
            <p>{{ $mail->body }}</p>
        </div>
    </div>
@endsection
