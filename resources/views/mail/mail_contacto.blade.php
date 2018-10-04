<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head></head>
<body>
Hola, has sido contactado por: {{$mail->nombre}}<br>
Datos del contacto:
<div>
    <p>
        Email: <a href="mailto:{{ $mail->email }}">{{ $mail->email }}</a>
    </p>
    <p>
        Telefono: <a href="mailto:{{ $mail->email }}">{{ $mail->email }}</a>
    </p>
    <p>{{ $mail->body }}</p>
</div>

</body>
</html>

