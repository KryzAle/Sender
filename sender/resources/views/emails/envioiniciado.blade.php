<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
    <body>
        <h2>¡ICONO SENDER!</h2>

        <div>
            Se inicio un nuevo envio desde la cuenta del usuario con el correo electronico {!! $parametro !!}
        </div>
        <p>
            Los parametros de envio fueron:
        </p>
        <br>
        <p><b>Tiempo de espera:</b> {!! $tiempoespera !!} segundos</p>
        <br>
        <p><b>Intervalo entre cada envio:</b> {!! $intervalo !!} segundos</p>
        <br>
        <p><b>Numero de envios antes de pausar:</b> {!! $numenvios !!} contactos</p>
        <br>
        <p><b>Tiempo de pausa:</b> {!! $tiempopause !!} minutos</p>

    </body>
</html>