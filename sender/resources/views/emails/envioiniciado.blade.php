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
        <table>
            <tr>
                <th>Tiempo de espera</th>
                <th>Intervalo entre cada envio</th>
                <th>Numero de envios antes de pausar</th>
                <th>Tiempo de pausa</th>
            </tr>
            <tr>
                <td>{!! $tiempoespera !!}</td>
                <td>{!! $intervalo !!}</td>
                <td>{!! $numenvios !!}</td>
                <td>{!! $tiempopause !!}</td>
            </tr>
        </table>

    </body>
</html>