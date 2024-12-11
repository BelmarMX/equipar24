<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Equi-par</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style type="text/css">
        *{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .row{
            display: inline-block;
            vertical-align: top;
            width: 100%;
        }
        .mb-1{
            margin-bottom: 8px;
        }
        .mb-3{
            margin-bottom: 32px;
        }
        .mb-5{
            margin-bottom: 64px;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- ? HEADER -->
        <div class="row mb-3">
            <div class="col-md-6" style="display: inline-block; vertical-align: top; width: 49%;">
                <img width="232" height="61" alt="Logo Equipar" src="{{ url('images/template/equipar-id--red.png') }}">
            </div>
            <div class="col-md-6" style="display: inline-block; vertical-align: top; width: 49%;">
                <h1 class="text-right" style="font-size: 48px">COTIZACIÓN WEB</h1>
            </div>
        </div>
        <!-- ? INFORMACIÓN GENERAL -->
        <div class="row mb-3">
            <div class="col-md-6" style="display: inline-block; vertical-align: top; width: 49%;">
                <p style="margin: 0;">
                    AV. CVLN. JORGE ALVAREZ DEL CASTILLO NÚM. EXT. 1442<br/>
                    LOMAS DEL COUNTRY C.P. 44610<br/>
                    GUADALAJARA, JALISCO. MÉXICO.<br/>
                    TEL. 33 28 86 26 61<br/>
                    <a href="https://equi-par.com/">WWW.EQUI-PAR.COM</a>
                </p>
            </div>
            <div class="col-md-6" style="display: inline-block; vertical-align: top; width: 49%;">
                <div class="row">
                    <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%; color:#0891b2;">FOLIO:</strong>
                    <b class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">{{ Str::padLeft($data->id, 5, '0') }}</b>
                </div>
                <div class="row">
                    <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%; color:#0891b2;">FECHA:</strong>
                    <b class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">{{ date('m/d/Y') }}</b>
                </div>
                <div class="row">
                    <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%; color:#0891b2;">CLIENTE:</strong>
                    <b class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">{{$data->form_contact->name}}</b>
                </div>
                <div class="row">
                    <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%; color:#0891b2;">ASESOR:</strong>
                    <b class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">WEB: ATENCIÓN A CLIENTES</b>
                </div>
                <div class="row">
                    <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%; color:#0891b2;">COMENTARIOS:</strong>
                    <b class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">{{ $data->comment }}</b>
                </div>
            </div>
        </div>
        @if( !empty($data->rejected_at) )
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    Lo sentimos, en este momento no fue posible generar tu cotización.
                </div>
            </div>
        @else
            <!-- ? COTIZACIÓN -->
            <div class="row mb-3">
                <div class="col-md-12 text-center bg-blue">
                    EQUIPO DE COCINA INDUSTRIAL
                </div>
                <div class="col-md-12 mb-3">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th class="text-center">PARTE</th>
                                <th class="text-center">IMAGEN</th>
                                <th class="text-center">MARCA/MODELO</th>
                                <th class="text-center">CONCEPTO</th>
                                <th class="text-center">CANT</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">DESC.</th>
                                <th class="text-center">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data->form_quotation_details()->get() AS $detail)
                            <tr>
                                <td class="text-right">{{ $detail->product_id }}</td>
                                <td class="text-center">
                                    <img src="{{ url('storage/'.$ImagesSettings::PRODUCT_FOLDER.$detail->product_image) }}" width="75" height="75" alt="{{ $detail->product_name }}" style="height: 75px; width: auto;">
                                </td>
                                <td>{{ $detail->product_brand }}/{{ $detail->product_model }}</td>
                                <td>{{ $detail->product_name }}</td>
                                <td class="text-right">{{$detail->quantity}}</td>
                                <td class="text-right">${{ number_format($detail->original_price) }}</td>
                                <td class="text-right">
                                    @if( isset($detail->promotion->title) && !is_null($detail->promotion->title) )
                                        {{ $detail->promotion->title ? ($detail->promotion->type=='fixed' ? "-$".$detail->promotion->amount : "-".$detail->promotion->amount."%" ) : NULL }}
                                    @endif
                                </td>
                                <td class="text-right">${{ number_format($detail->quantity * $detail->total) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">
                    &nbsp;
                </div>
                <div class="col-md-4" style="display: inline-block; vertical-align: top; width: 33%;">
                    <div class="row">
                        <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%;">SUBTOTAL:</strong>
                        <span class="col-md-8 text-right" style="display: inline-block; vertical-align: top; width: 65%;">${{ number_format($totals->original, 2) }}</span>
                    </div>
                    <div class="row">
                        <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%;">DESCUENTO:</strong>
                        <span class="col-md-8 text-right" style="display: inline-block; vertical-align: top; width: 65%;">${{ number_format($totals->discount, 2) }}</span>
                    </div>
                    <div class="row">
                        <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%;">IVA:</strong>
                        <span class="col-md-8 text-right" style="display: inline-block; vertical-align: top; width: 65%;">${{ number_format($totals->iva, 2) }}</span>
                    </div>
                    <div class="row">
                        <strong class="col-md-4 text-right" style="display: inline-block; vertical-align: top; width: 33%;">TOTAL:</strong>
                        <span class="col-md-8 text-right" style="display: inline-block; vertical-align: top; width: 65%;">${{ number_format($totals->total + $totals->iva, 2) }}</span>
                    </div>
                </div>
            </div>
            <!-- ? INFORMACIÓN DE MONEDA -->
            <div class="row mb-3">
                <div class="col-md-6" style="display: inline-block; vertical-align: top; width: 49%;">
                    <div class="mb-1 bg-black">
                        Precio unitario en pesos mexicanos (MXN)
                    </div>
                    <div class="bg-black">
                        Más el 16% de IVA
                    </div>
                </div>
            </div>
            <!-- ? ACUERDOS COMERCIALES -->
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h3>ACUERDOS COMERCIALES</h3>
                </div>
                <div class="row mb-1">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">TIEMPO DE ENTREGA</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">POR DEFINIR</div>
                </div>
                <div class="row mb-1">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">FORMA DE PAGO</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">70% ANTICIPO, 30% AVISO DE ENTREGA</div>
                </div>
                <div class="row mb-1">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">INSTALACIÓN</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">NO INCLUYE PARTIDA DE INSTALACIÓN, NO INCLUYE TRABAJOS DE OBRA CIVIL, FONTANERÍA NI ELECTRICIDAD, ASÍ COMO EXTRACCIÓN Y DUCTERIA DE CAMPANAS, TRAMPAS DE GRASA NI REJILLAS DE PISO.</div>
                </div>
                <div class="row mb-1">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">GENERALES</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">NO SE ACEPTAN CAMBIOS NI DEVOLUCIONES.<br/>VIGENCIA DE LA COTIZACIÓN 10 DÍAS.</div>
                </div>
                <div class="row mb-1">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">FLETE Y TRANSPORTE</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">MERCANCÍA LIBRE A BORDO GUADALAJARA, JALISCO. LIBRE DE MANIOBRAS (PIE DE PUERTA)</div>
                </div>
                <div class="row mb-1">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">GARANTÍA</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">1 AÑO DE GARANTÍA ANTE DEFECTO DE FABRICACIÓN (NO APLICA EN PIEZAS ELÉCTRICAS NI CONSUMIBLES).<br/>*IMPORTANTE* REALIZAR SERVICIOS DE MANTENIMIENTO PREVENTIVO.</div>
                </div>
                <div class="row">
                    <strong class="col-md-4 text-center bg-gray" style="display: inline-block; vertical-align: top; width: 33%;">DATOS BANCARIOS</strong>
                    <div class="col-md-8" style="display: inline-block; vertical-align: top; width: 66%;">BANCO SANTANDER &nbsp;&nbsp;&nbsp; NO. CUENTA: 65507954256 &nbsp;&nbsp;&nbsp; CLABE: 014320655079542568</div>
                </div>
            </div>
            <!-- ? FIRMA DEL CLIENTE -->
            <div class="row mb-3">
                <div class="col-md-4" style="display: inline-block; vertical-align: top; width: 33%;">&nbsp;</div>
                <div class="col-md-4 text-center" style="display: inline-block; vertical-align: top; width: 33%; border-top: 1px solid #000;">
                    FIRMA DE ACEPTACIÓN DEL CLIENTE<br/>
                    ACEPTO LOS TÉRMINOS COMERCIALES A ENTERA SATISFACCIÓN
                </div>
                <div class="col-md-4" style="display: inline-block; vertical-align: top; width: 33%;">&nbsp;</div>
            </div>
        @endif

        @if( !empty($data->approved_at) || !empty($data->rejected_at) )
            <div class="row mb-1">
                <div class="col-md-12 text-center">
                    <strong>Respuesta del agente:</strong><br/>
                    <p>{{ $data->notes }}</p>
                </div>
            </div>
            <!-- ? ATENTAMENTE -->
            <div class="row">
                <div class="col-md-4" style="display: inline-block; vertical-align: top; width: 33%;">&nbsp;</div>
                <div class="col-md-4 text-center" style="display: inline-block; vertical-align: top; width: 33%; border-top: 1px solid #000;">
                    ATENTAMENTE<br/>{{ !empty($data->approved_at) ? $data->approved_by->name : $data->rejected_by->name }}
                </div>
                <div class="col-md-4" style="display: inline-block; vertical-align: top; width: 33%;">&nbsp;</div>
            </div>
        @endif
    </div>
</body>
</html>
