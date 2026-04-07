<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restablecer Contraseña</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f4f8;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0f4f8;padding:40px 16px;">
    <tr>
        <td align="center">
            <table width="580" cellpadding="0" cellspacing="0" border="0" style="max-width:580px;width:100%;">

                <!-- HEADER -->
                <tr>
                    <td style="background-color:#071D36;border-radius:16px 16px 0 0;padding:32px 40px;text-align:center;">
                        <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                            <tr>
                                <td style="vertical-align:middle;padding-right:12px;">
                                    <div style="width:48px;height:48px;background-color:#1a3a5c;border:2px solid #C9A84C;border-radius:12px;text-align:center;line-height:44px;font-size:22px;">
                                    🏛️
                                    </div>
                                </td>
                                <td style="vertical-align:middle;text-align:left;">
                                    <div style="font-size:20px;font-weight:700;color:#ffffff;letter-spacing:0.5px;">Comunal Aprende</div>
                                    <div style="font-size:11px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:2px;margin-top:2px;">Colombia · Formación Comunitaria</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- LÍNEA DORADA -->
                <tr>
                    <td style="background-color:#C9A84C;height:3px;font-size:0;line-height:0;">&nbsp;</td>
                </tr>

                <!-- CUERPO -->
                <tr>
                    <td style="background-color:#ffffff;padding:40px 40px 32px;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0;">

                        <!-- Icono central -->
                        <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto 28px;">
                            <tr>
                                <td style="width:72px;height:72px;background-color:#EBF3FF;border:2px solid #c5d9f0;border-radius:36px;text-align:center;vertical-align:middle;font-size:28px;">
                                🔐
                                </td>
                            </tr>
                        </table>

                        <!-- Saludo -->
                        <p style="font-size:22px;font-weight:700;color:#071D36;margin:0 0 12px 0;">Hola, {{ $name }} 👋</p>

                        <!-- Texto principal -->
                        <p style="font-size:15px;color:#475569;line-height:1.7;margin:0 0 28px 0;">
                            Recibimos una solicitud para <strong style="color:#071D36;font-weight:600;">restablecer la contraseña</strong>
                            de tu cuenta en Comunal Aprende. Si fuiste tú, haz clic en el botón de abajo para continuar:
                        </p>

                        <!-- Botón -->
                        <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto 32px;">
                            <tr>
                                <td style="background-color:#0A4D8C;border-radius:10px;text-align:center;">
                                    <a href="{{ $url }}"
                                        style="display:inline-block;padding:16px 40px;font-size:16px;font-weight:700;color:#ffffff;text-decoration:none;letter-spacing:0.3px;">
                                        🔑 &nbsp; Restablecer mi Contraseña
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Caja de expiración -->
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:20px;">
                            <tr>
                                <td style="background-color:#FFF8EE;border:1px solid #f0d490;border-radius:10px;padding:14px 18px;">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td style="font-size:18px;vertical-align:top;padding-right:12px;width:24px;">⏱️</td>
                                            <td style="font-size:13px;color:#854F0B;line-height:1.6;">
                                                <strong>Este enlace expira en {{ $expire }} minutos.</strong><br>
                                                Si no completas el proceso a tiempo, deberás solicitar uno nuevo desde la página de inicio de sesión.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Caja no solicitaste -->
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:28px;">
                            <tr>
                                <td style="background-color:#f8fafc;border-radius:10px;padding:14px 18px;font-size:13px;color:#64748b;line-height:1.6;">
                                🛡️ &nbsp;<strong style="color:#334155;">¿No solicitaste este cambio?</strong>
                                No hay problema — puedes ignorar este correo con total seguridad. Tu contraseña no cambiará.
                                </td>
                            </tr>
                        </table>

                        <!-- Divider -->
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:20px;">
                            <tr>
                                <td style="border-top:1px solid #e2e8f0;font-size:0;line-height:0;">&nbsp;</td>
                            </tr>
                        </table>

                        <!-- URL fallback -->
                        <p style="font-size:12px;color:#94a3b8;line-height:1.6;margin:0;">
                            Si el botón no funciona, copia y pega este enlace en tu navegador:<br>
                            <a href="{{ $url }}" style="color:#0A4D8C;word-break:break-all;">{{ $url }}</a>
                        </p>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="background-color:#071D36;border-radius:0 0 16px 16px;padding:24px 40px;text-align:center;">
                        <p style="font-size:12px;color:rgba(255,255,255,0.4);line-height:1.7;margin:0;">
                        © {{ date('Y') }} Comunal Aprende · Colombia<br>
                        Este correo fue enviado automáticamente, por favor no respondas a este mensaje.<br>
                        <a href="{{ url('/') }}" style="color:rgba(255,255,255,0.6);text-decoration:none;">comunalaprende.com</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>