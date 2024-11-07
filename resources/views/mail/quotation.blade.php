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
                                    <p>Recibimos tu solicitud de cotización y hemos enviado una respuesta:</p>
                                    <br>
                                    <p><b>Nombre:</b> {{ $data->form_contact->name }}</p>
                                    <p><b>Correo electrónico:</b> {{ $data->form_contact->email }}</p>
                                    <p><b>Celular:</b> {{ $data->form_contact->phone }}</p>
                                    <p><b>Empresa:</b> {{ $data->form_contact->company }}</p>
                                    <p><b>Estado:</b> {{ $data->form_contact->state->name }}</p>
                                    <p><b>Ciudad:</b> {{ $data->form_contact->city->name }}</p>
                                    <p><b>Comentarios:</b> {{ $data->comment }}</p>
                                    @if( !empty($data->rejected_at) )
                                        <br>
                                        <p style="text-align: center">Lo sentimos, en este momento no fue posible generar tu cotización.</p>
                                    @else
                                    <br>
                                    <br>
                                    <p><b>Detalle de los productos solicitados:</b></p>
                                    <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                        <thead style="border-bottom: 1px solid #e5e5e5">
                                        <tr>
                                            <th style="padding:1px 2px">Producto</th>
                                            <th style="padding:1px 2px"></th>
                                            <th style="padding:1px 2px; text-align: center;">Cant.</th>
                                            <th style="padding:1px 2px; text-align: center;">P. original</th>
                                            <th style="padding:1px 2px; text-align: center;">Desc.</th>
                                            <th style="padding:1px 2px; text-align: center;">Precio final</th>
                                            <th style="padding:1px 2px; text-align: center;">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->form_quotation_details()->get() AS $detail)
                                            <tr style="border-bottom: 1px solid #e5e5e5">
                                                <td style="padding:1px 2px; min-width: 250px; border-bottom: 1px solid #e5e5e5">
                                                    <small>{{ $detail->product_name }}</small>
                                                </td>
                                                <td style="padding:1px 2px; border-bottom: 1px solid #e5e5e5">
                                                    @if( isset($detail->promotion->title) && !is_null($detail->promotion->title) )
                                                        <small>{{ $detail->promotion->title ? ($detail->promotion->type=='fixed' ? "-$".$detail->promotion->amount : "-".$detail->promotion->amount."%" ) : NULL }}</small>
                                                    @endif
                                                </td>
                                                <td style="padding:1px 2px; text-align: right; border-bottom: 1px solid #e5e5e5">{{ $detail->quantity }}</td>
                                                <td style="padding:1px 2px; text-align: right; border-bottom: 1px solid #e5e5e5">${{ number_format($detail->original_price) }}</td>
                                                <td style="padding:1px 2px; text-align: right; border-bottom: 1px solid #e5e5e5">${{ number_format($detail->discount) }}</td>
                                                <td style="padding:1px 2px; text-align: right; border-bottom: 1px solid #e5e5e5">${{ number_format($detail->total) }}</td>
                                                <td style="padding:1px 2px; text-align: right; border-bottom: 1px solid #e5e5e5">${{ number_format($detail->quantity * $detail->total) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="border-b border-neutral-200">
                                            <td style="padding:1px 2px; text-align: right" colspan="3"><strong>TOTAL</strong></td>
                                            <td style="padding:1px 2px; text-align: right">${{ number_format($totals->original) }}</td>
                                            <td style="padding:1px 2px; text-align: right">${{ number_format($totals->discount) }}</td>
                                            <td style="padding:1px 2px; text-align: right"></td>
                                            <td style="padding:1px 2px; text-align: right">${{ number_format($totals->total) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                    @if( !empty($data->approved_at) || !empty($data->rejected_at) )
                                        <br><br>
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
