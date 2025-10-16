<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Carta Oferta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        @page {
            size: Letter;
            margin: 4cm 2.5cm 2.5cm 2.5cm;
        }
        header {
                position: fixed;
                top: -1.5cm;
                left: 0;
                right: 0;
                height: 1.5cm;
            }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .container {
            padding: 0cm;
        }

        .empresa {
            font-size: 25px;
            color: #0d6efd;
            font-weight: bold;
            text-align: center;
        }

        .detalle-empresa {
            font-size: 12px;
            color: #0d6efd;
            text-align: center;
        }

        .titulo {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding-top: 10px;
        }

        .fecha {
            font-size: 13px;
            text-align: right;
            padding-top: 20px;
        }

        .s14 {
            font-size: 13px;
        }

        .b-s14 {
            font-size: 13px;
            font-weight: bold;
        }

        .pt-4 { padding-top: 0.5rem; }
        .pe-5 { padding-right: 2rem; }
        .text-justify { text-align: justify; }
        .text-end { text-align: right; }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .w-100 { width: 100%; }

        ol {
            padding-left: 5px;
        }

        ol li {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            margin-top: 30px;
        }

        table td {
            vertical-align: top;
            text-align: center;
        }
        firmas { 
            position: fixed;
            bottom: -1.5cm;
            left: 0;
            right: 0;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -2.5cm;
            left: 0;
            right: 0;
            height: 1cm;
            text-align: left;
            font-size: 8pt;
            color: #777;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="titulo">CARTA OFERTA DE TRABAJO</div>
    <div class="fecha">Panamá, {{ $data['fecha_actual'] }}</div>

    <div class="s14 pt-4">{{ $data['sr'] }}</div>
    <div class="b-s14">{{ $data['prinombre'] }} {{ $data['segnombre'] }} {{ $data['priapellido'] }} {{ $data['segapellido'] }}</div>
    <div class="s14">E. S. M.</div>

    <p class="s14 pt-4">{{ $data['sr'] }} {{ $data['priapellido'] }},</p>

    <p class="s14 text-justify">
        Tengo el agrado de ofrecer a usted, en nombre de <strong>{{ $data['nombre_memb'] }}</strong>, el puesto de
        <strong>{{ $data['puesto'] }}</strong> bajo las condiciones que se detallan a continuación:
    </p>

    <ol class="s14">
        <li><strong>Fecha de inicio:</strong> {{ $data['fecha_larga_inicio'] }}</li>
        <li><strong>Remuneración:</strong><br>
            <ul>
                <li>Su salario será de B/. <strong>{{ $data['salario'] }} mensual</strong></li>
                @if (!empty($data['texto_beneficios']))
                    @foreach ($data['texto_beneficios'] as $beneficio)
                        @if($beneficio['tipo'] == 'b')
                            <li>{!! $beneficio['text'] !!}</li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </li>
        @if (!empty($data['texto_beneficios']))
        <li><strong>Herramientas de trabajo y bineficios:</strong><br>
            <ul>
                @foreach ($data['texto_beneficios'] as $beneficio)
                    @if($beneficio['tipo'] == 'h')
                        <li>{!! $beneficio['text'] !!}</li>
                    @endif
                @endforeach
            </ul>
        </li>
        @endif
        @if (!empty($data['plazo_nombramiento']))
        <li><strong>Plazo del nombramiento:</strong><br>
            <p class="text-justify" style="margin: 0;">
                {!! nl2br($data['plazo_nombramiento']) !!}
            </p>
        </li>
        @endif
    </ol>

    <firmas>   
        <div class="s14 text-left">Atentamente,</div>
        <table class="s14">
            <tr>
                <td style="width: 50%;">
                    <div >_______________________________</div>
                    <div class="s14">{{ $data['firmante'] }}</div>
                    <div>{{ $data['puestofirmante'] }}</div>
                </td>
                <td style="width: 50%;">
                    <div >___________________________</div>
                    <div class="s14">Firma de aceptación</div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div >___________________________</div>
                    <div class="s14">Cédula</div>
                </td>
            </tr>
        </table>
    </firmas>
    <footer>
        CC.: Expediente Personal
    </footer>
</div>

</body>
</html>
