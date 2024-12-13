<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Equi-par</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style type="text/css">
        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }
        body {
            background-color: #f8fafc;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        table {
            border-collapse: separate;
            mso-table-lspace: 0;
            mso-table-rspace: 0;
            min-width: 100%;
            width: 100%;
        }
        table td {
            font-family: sans-serif;
            font-size: 12px;
            vertical-align: top;
        }
        table td.border-b{
            border-bottom: 1px dashed #0891b2;
            padding: 5px 2px;
            vertical-align: middle;
        }
        table td.border-t{
            border-top: 1px solid #0a0a0a;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */
        .body {
            background-color: #f8fafc;
            width: 100%;
        }
        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 98%;
            padding: 10px;
            width: 98%;
        }
        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            Margin: 0 auto;
            max-width: 98%;
            padding: 10px;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }
        .header {
            padding: 20px 0;
        }
        .wrapper {
            box-sizing: border-box;
            padding: 20px;
        }
        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }
        .footer {
            clear: both;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #0f172a;
            font-size: 12px;
            text-align: center;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #0a0a0a;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }
        h1 {
            font-size: 35px;
            font-weight: 600;
            text-align: center;
            text-transform: capitalize;
        }
        p,
        ul,
        ol {
            font-family: sans-serif;
            font-size: 12px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }
        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }
        a {
            color: #d5ac63;
            text-decoration: underline;
        }

        /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%;
        }
        .btn > tbody > tr > td {
            padding-bottom: 15px;
        }
        .btn table {
            min-width: auto;
            width: auto;
        }
        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }
        .btn a {
            background-color: #ffffff;
            border: solid 1px #d5ac63;
            border-radius: 5px;
            box-sizing: border-box;
            color: #d5ac63;
            cursor: pointer;
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
        }
        .btn-primary table td {
            background-color: #d5ac63;
        }
        .btn-primary a {
            background-color: #d5ac63;
            border-color: #d5ac63;
            color: #ffffff;
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        .last {
            margin-bottom: 0;
        }
        .first {
            margin-top: 0;
        }
        .text-center,
        .align-center {
            text-align: center;
        }
        .text-right,
        .align-right {
            text-align: right;
        }
        .text-left,
        .align-left {
            text-align: left;
        }
        .clear {
            clear: both;
        }
        .mt-0,
        .mt0 {
            margin-top: 0;
        }
        .mb-0,
        .mb0 {
            margin-bottom: 0;
        }
        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }
        .powered-by a {
            text-decoration: none;
        }
        .apple-link{
            color: #FF0000 !important;
        }
        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            Margin: 20px 0;
        }

        .bg-blue{
            background-color: #0891b2;
            color: #FFF;
            padding: 5px;
        }
        .bg-black{
            background-color: #0a0a0a;
            color: #FFFFFF;
            padding: 0 5px;
        }
        .bg-gray{
            background-color: #6b7280;
            color: #FFFFFF;
        }

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }
            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }
            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }
            table[class=body] .content {
                padding: 0 !important;
            }
            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }
            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }
            table[class=body] .btn table {
                width: 100% !important;
            }
            table[class=body] .btn a {
                width: 100% !important;
            }
            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }
            .btn-primary table td:hover {
                background-color: #d5075d !important;
            }
            .btn-primary a:hover {
                background-color: #d5075d !important;
                border-color: #d5075d !important;
            }
        }
    </style>
</head>
<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="header">
                    <span class="preheader">🍽 <b>¡Hola, {{$data->form_contact->name}}!</b> agradecemos tu interés Equi-par, a continuación te hacemos llegar los detalles de tu cotización.</span>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="text-left" width="50%">
                                <a href="https://equi-par.com">
                                    <img width="232" height="61" alt="Logo Equipar" src="https://equi-par.com/images/template/equipar-id--red.png">
                                </a>
                            </td>
                            <td class="text-right" width="50%">
                                <h1 class="text-right">COTIZACIÓN WEB</h1>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <p style="margin: 0;">
                                    AV. CVLN. JORGE ALVAREZ DEL CASTILLO NÚM. EXT. 1442<br/>
                                    LOMAS DEL COUNTRY C.P. 44610<br/>
                                    GUADALAJARA, JALISCO. MÉXICO.<br/>
                                    TEL. 33 28 86 26 61<br/>
                                    <a href="https://equi-par.com/">WWW.EQUI-PAR.COM</a>
                                </p>
                            </td>
                            <td width="50%">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="text-right" width="30%"><b>FOLIO:</b>&nbsp;</td>
                                        <td width="70%">{{ Str::padLeft($data->id, 7, '0') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="30%"><b>FECHA:</b>&nbsp;</td>
                                        <td width="70%">{{ date('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="30%"><b>CLIENTE:</b>&nbsp;</td>
                                        <td width="70%">{{$data->form_contact->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="30%"><b>ASESOR:</b>&nbsp;</td>
                                        <td width="70%">WEB: ATENCIÓN A CLIENTES</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="30%"><b>COMENTARIOS:</b>&nbsp;</td>
                                        <td width="70%">{{ $data->comment }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="content">
                    <span class="preheader_show"><b>¡Hola, {{$data->form_contact->name}}!</b> agradecemos tu interés Equi-par, a continuación te hacemos llegar los detalles de tu cotización.</span>
                    <br/>
                    <br/>
                    @if( !empty($data->approved_at) || !empty($data->rejected_at) )
                        {{--<span class="preheader"><b>Nuestro agente de atención ha dejado un mensaje:</b></span>
                        <br/>--}}
                        <p style="margin: 0">{{ $data->notes }}</p>
                        <br/>
                    @endif
                    <span class="preheader_show">Si tienes alguna duda o comentario adicional, por favor contactanos al whatsapp al</span> <a href="https://api.whatsapp.com/send?phone=523322876603&text=Para%20brindarte%20un%20mejor%20servicio%20por%20favor%20deja%20tus%20datos%20({{$data->form_contact->name}},%20{{$data->form_contact->email}},%20%20y%20asunto:%20Cotización web ID:{{ $data->id }})">33 2287 6603</a> <span class="preheader_show">o respondiendo a este correo electrónico (</span><a href="mailto:atencionaclientes@equi-par.com">atencionaclientes@equi-par.com</a><span class="preheader_show">) donde con gusto resolveremos tus preguntas.</span>
                    <br/>
                    <br/>
                    <!-- START CENTERED WHITE CONTAINER -->
                    <div class="bg-blue text-center">
                        EQUIPO DE COCINA INDUSTRIAL
                    </div>
                    <table role="presentation" class="main">
                        <!-- START MAIN CONTENT AREA -->
                        <!-- ? COTIZACION -->
                        <tr>
                            <td class="wrapper">
                                @if( !empty($data->rejected_at) )
                                    Lo sentimos, en este momento no fue posible generar tu cotización.
                                @else
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>PARTE</th>
                                        <th>IMAGEN</th>
                                        <th>MARCA/MODELO</th>
                                        <th>CONCEPTO</th>
                                        <th>CANT.</th>
                                        <th>PRECIO</th>
                                        <th>DESC.</th>
                                        <th>SUBTOTAL</th>
                                    </tr>
                                    <!-- ? COTIZACION DETALLE -->
                                    @foreach($data->form_quotation_details()->get() AS $detail)
                                    <tr>
                                        <td width="10%" class="border-b text-right">{{ Str::padLeft($detail->product_id, 7, '0') }}</td>
                                        <td width="10%" class="border-b text-center">
                                            <img src="{{ url('storage/'.$ImagesSettings::PRODUCT_FOLDER.$detail->product_image) }}" width="75" height="75" alt="{{ $detail->product_name }}" style="height: 75px; width: auto;">
                                        </td>
                                        <td width="10%" class="border-b">{{ $detail->product_brand }}<br/>{{ $detail->product_model }}</td>
                                        <td width="30%" class="border-b">{{ $detail->product_name }}</td>
                                        <td width="10%" class="border-b text-right">{{$detail->quantity}}</td>
                                        <td width="10%" class="border-b text-right">${{ number_format($detail->original_price, 2) }}</td>
                                        <td width="10%" class="border-b text-right">${{ number_format($detail->discount, 2) }}</td>
                                        <td width="10%" class="border-b text-right">${{ number_format($detail->quantity * $detail->total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif
                            </td>
                        </tr>
                        <!-- ? PRECIO FINAL -->
                        @if( empty($data->rejected_at) )
                        <tr>
                            <td class="wrapper text-right">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="text-right" width="75%"><b>SUBTOTAL:</b>&nbsp;</td>
                                        <td class="text-right" width="25%">${{ number_format($totals->original, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="75%"><b>DESCUENTO:</b>&nbsp;</td>
                                        <td class="text-right" width="25%">${{ number_format($totals->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="75%"><b>IVA:</b>&nbsp;</td>
                                        <td class="text-right" width="25%">${{ number_format($totals->iva, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" width="75%"><b>TOTAL:</b>&nbsp;</td>
                                        <td class="text-right" width="25%"><b>${{ number_format($totals->total, 2) }}</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- ? DETALLES DEL COSTO -->
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50%" class="bg-black">PRECIO UNITARIO EN PESOS MEXICANOS (MXN)</td>
                                        <td width="50%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="50%" class="bg-black">INCLUYE 16% DE IVA</td>
                                        <td width="50%">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- ? ACUERDOS COMERCIALES -->
                        <tr>
                            <td class="wrapper">
                                <h3 class="text-center">ACUERDOS COMERCIALES</h3>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="5">
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>TIEMPO DE ENTREGA</b></td>
                                        <td width="65%">POR DEFINIR</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>FORMA DE PAGO</b></td>
                                        <td width="65%">70% ANTICIPO, 30% AVISO DE ENTREGA</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>INSTALACIÓN</b></td>
                                        <td width="65%">NO INCLUYE PARTIDA DE INSTALACIÓN, NO INCLUYE TRABAJOS DE OBRA CIVIL, FONTANERÍA NI ELECTRICIDAD, ASÍ COMO EXTRACCIÓN Y DUCTERIA DE CAMPANAS, TRAMPAS DE GRASA NI REJILLAS DE PISO.</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>GENERALES</b></td>
                                        <td width="65%">NO SE ACEPTAN CAMBIOS NI DEVOLUCIONES.<br/>VIGENCIA DE LA COTIZACIÓN 10 DÍAS.</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>FLETE Y TRANSPORTE</b></td>
                                        <td width="65%">MERCANCÍA LIBRE A BORDO GUADALAJARA, JALISCO. LIBRE DE MANIOBRAS (PIE DE PUERTA)</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>GARANTÍA</b></td>
                                        <td width="65%">1 AÑO DE GARANTÍA ANTE DEFECTO DE FABRICACIÓN (NO APLICA EN PIEZAS ELÉCTRICAS NI CONSUMIBLES).<br/>*IMPORTANTE* REALIZAR SERVICIOS DE MANTENIMIENTO PREVENTIVO.</td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="bg-gray text-center" style="vertical-align: middle;"><b>DATOS BANCARIOS</b></td>
                                        <td width="65%">BANCO SANTANDER &nbsp;&nbsp;&nbsp; NO. CUENTA: 65507954256 &nbsp;&nbsp;&nbsp; CLABE: 014320655079542568</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        @endif
                        <!-- ? FIRMAS -->
                        <tr>
                            <td class="wrapper">
                                <br/>
                                <br/>
                                <br/>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="5">
                                    @if( empty($data->rejected_at) )
                                    <tr>
                                        <td width="30%">&nbsp;</td>
                                        <td width="40%" class="border-t text-center">
                                            FIRMA DE ACEPTACIÓN DEL CLIENTE<br/>
                                            ACEPTO LOS TÉRMINOS COMERCIALES A ENTERA SATISFACCIÓN
                                        </td>
                                        <td width="30%">&nbsp;</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td width="30%">&nbsp;</td>
                                        <td width="40%">
                                            &nbsp;<br/>
                                            &nbsp;<br/>
                                        </td>
                                        <td width="30%">&nbsp;</td>
                                    </tr>
                                    @if( !empty($data->approved_at) || !empty($data->rejected_at) )
                                    <tr>
                                        <td width="30%">&nbsp;</td>
                                        <td width="40%" class="border-t text-center">
                                            ATENTAMENTE<br/>
                                            {{ !empty($data->approved_at) ? $data->approved_by->name : $data->rejected_by->name }}<br/>
                                            Equi-par Cocinas Industriales
                                        </td>
                                        <td width="30%">&nbsp;</td>
                                    </tr>
                                    @endif
                                </table>
                            </td>
                        </tr>
                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <!-- START FOOTER -->
                    <div class="footer">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <span class="apple-link">¡Aseguramos la eficiencia de tu cocina!</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="content-block powered-by">
                                    <a href="https://equi-par.com">equi-par.com</a>.
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>
</html>
