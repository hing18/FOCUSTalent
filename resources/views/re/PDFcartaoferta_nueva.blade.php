<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de Oferta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            margin: 3cm 2.5cm 2.5cm 2.5cm;
            line-height: 1.5;
        }

        h1, h2, h3, h4 {
            margin: 0;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .firma {
            margin-top: 3cm;
        }

        ul {
            padding-left: 20px;
        }

        .fecha {
            margin-bottom: 1cm;
        }

        .membrete {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1cm;
        }

        .saludo {
            margin-top: 1cm;
        }

        .beneficios {
            margin-top: 1cm;
        }

        .footer {
            margin-top: 2cm;
        }
    </style>
</head>
<body>

    @php
        $genero = strtolower($data['genero']);
        $tratamiento = $genero === 'f' ? 'Estimada' : 'Estimado';
        $nombreCompleto = trim("{$data['prinombre']} {$data['segnombre']} {$data['priapellido']} {$data['segapellido']}");
    @endphp

    <div class="membrete">
        {{ strtoupper($data['nombre_memb']) }}
    </div>

    <div class="fecha right">
        Panamá, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
    </div>

    <p>{{ $tratamiento }} {{ $nombreCompleto }},</p>

    <p class="saludo">
        Por medio de la presente, nos complace ofrecerle el cargo de <span class="bold">{{ $data['puesto'] }}</span> en nuestra organización, con fecha de inicio el <span class="bold">{{ $data['fecha_larga_inicio'] }}</span>, bajo la modalidad de <span class="bold">{{ $data['sel_tipo_contrato'] }}</span>.
    </p>

    <p>
        La remuneración mensual será de <span class="bold">${{ number_format($data['salario'], 2) }}</span>.
        Este monto se establece bajo el esquema de <span class="bold">{{ $data['sel_tipo_salario'] }}</span>.
    </p>

    @if (!empty($data['beneficios']))
        <div class="beneficios">
            <p>Adicionalmente, se le otorgarán los siguientes beneficios:</p>
            <ul>
                @foreach ($data['beneficios'] as $beneficio)
                    <li>{{ $beneficio['nombre'] }} 
                        @if(isset($beneficio['monto']) && is_numeric($beneficio['monto']) && $beneficio['monto'] > 0)
                            - ${{ number_format($beneficio['monto'], 2) }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($data['fterminacion']))
        <p>
            Esta oferta tendrá vigencia hasta el <span class="bold">{{ \Carbon\Carbon::parse($data['fterminacion'])->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</span>, salvo que ambas partes acuerden una extensión o cambio de condiciones.
        </p>
    @endif

    <p>
        Le agradecemos por considerar esta propuesta. Quedamos atentos a su aceptación para formalizar los siguientes pasos.
    </p>

    <div class="firma">
        ___________________________<br>
        Firma autorizada<br>
        {{ strtoupper($data['nombre_memb']) }}
    </div>

</body>
</html>
