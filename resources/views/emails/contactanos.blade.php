<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h4>Programación de Entrevista Funcional</h4>
    <p>Sr(a). <strong>{{ $data['nom_entrevistador'] }}</strong><br>
    Me complace informarle que hemos programado una entrevista funcional con el candidato <strong>{{ $data['nombre'] }}</strong> para el puesto de <strong>{{ $data['descpue'] }}</strong> de la unidad económica <strong>{{ $data['nameund'] }}</strong>. Cuyo propósito del puesto es {{ $data['proposito'] }}</p>
    <p>   A continuación, le proporciono los detalles:</p>
        <ul>
            <li>Fecha: {{ $data['fecha'] }}</li>
            <li>Hora: {{ $data['hora'] }}</li>
        </ul>
    <p>Adjunto podrá encontrar la hoja de vida del candidato</p>
    <br>
    <p>Saludos<br>
    Dirección Corporativa de Gente y Organización</p>
</body>