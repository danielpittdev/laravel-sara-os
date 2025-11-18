<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #fff;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Recuperación de Contraseña</h1>
    </div>

    <div class="content">
        <p>Hola {{ $user->nombre }} {{ $user->apellido }},</p>

        <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta. Si no realizaste esta solicitud, puedes ignorar este correo electrónico.</p>

        <p>Para restablecer tu contraseña, haz clic en el siguiente enlace:</p>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="button">Restablecer Contraseña</a>
        </div>

        <p>Si tienes problemas para hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
        <p style="word-break: break-all; color: #007bff;">{{ $url }}</p>

        <div class="warning">
            <strong>Importante:</strong>
            <ul>
                <li>Este enlace expirará en 1 hora por razones de seguridad.</li>
                <li>Solo puedes usar este enlace una vez.</li>
                <li>Si no solicitaste este cambio, tu cuenta sigue siendo segura.</li>
            </ul>
        </div>

        <p>Si tienes algún problema o pregunta, no dudes en contactarnos.</p>

        <p>Saludos cordiales,<br>
        El equipo de {{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>Este es un correo electrónico automático, por favor no responder.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
    </div>
</body>
</html>