<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Equi-par</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        td, p, a, small, strong{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td style="text-align: center;">
                        <img width="232" height="61" alt="Logo Equipar" src="https://www.equi-par.com/images/template/equipar-id--red.png">
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <br>
                                    <br>
                                    <strong>Hola {{ $data->form_contact->name }}</strong>
                                    <p>Recibimos tu solicitud de contacto y hemos enviado una respuesta:</p>
                                    <br>
                                    <p><b>Nombre:</b> {{ $data->form_contact->name }}</p>
                                    <p><b>Correo electrónico:</b> {{ $data->form_contact->email }}</p>
                                    <p><b>Celular:</b> {{ $data->form_contact->phone }}</p>
                                    <p><b>Empresa:</b> {{ $data->form_contact->company }}</p>
                                    <p><b>Estado:</b> {{ $data->form_contact->state->name }}</p>
                                    <p><b>Ciudad:</b> {{ $data->form_contact->city->name }}</p>
                                    <p><b>Comentarios:</b> {{ $data->comment }}</p>
                                    @if( !empty($data->approved_at) || !empty($data->rejected_at) )
                                    <hr>
                                    <strong>Respuesta del agente:</strong>
                                    <br>
                                    <p>{{ $data->notes }}</p>
                                    <br>
                                    <p style="text-align: center">
                                        Saludos cordiales,<br>
                                        {{ !empty($data->approved_at) ? $data->approved_by->name : $data->rejected_by->name }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;">
                        <br>
                        <br>
                        <small>Equi-par.com Todos los derechos reservados</small>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <a href="{{ route('aviso-privacidad') }}"><small>Consulta nuestro aviso de privacidad</small></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
