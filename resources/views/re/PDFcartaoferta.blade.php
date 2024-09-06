<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>
<style>
    .font-arial{
        
        font-family: Arial, Helvetica, sans-serif;
    }
    .PAGADORA{
        font-size: 36px;
        color: #595959;
        font-weight: bold;
        text-align: center;
    }
    .apartado{
        font-size: 14px;
        color: #595959;
        font-weight: bold;
        text-align: center;
    }
    .b-s16{
        font-size: 16px;
        font-weight: bold;
    }
    
    .s14{
        font-size: 14px;
    }.b-s14{
        font-size: 14px;
        font-weight: bold;
       
        
    }
</style>
@php    $array[] =  json_decode($data); @endphp
@foreach ($array as $item)
@php
    $nombre_memb= $item->nombre_memb;
    $apartado= $item->apartado;
    $email= $item->email;
    $tel= $item->tel;
    $fecha_actual= $item->fecha_actual;
    $sr= $item->sr;
    $estimado= $item->estimado;

    $descpue= $item->descpue;
    $prinombre= $item->prinombre;
    $segnombre= $item->segnombre;
    $priapellido= $item->priapellido;
    $segapellido= $item->segapellido;
    $salario= $item->salario;
    $finicio= $item->finicio;
    $fterminacion= $item->fterminacion;
    $firmante= $item->firmante;
    $puestofirmante= $item->puestofirmante;
    $emailfirmante= $item->emailfirmante;


    if($item->sel_tipo_contrato=='T'){$sel_tipo_contrato='definido de once (11) meses';}
    if($item->sel_tipo_contrato=='P'){$sel_tipo_contrato='indefinido';}
    
    $fecha_larga_inicio= $item->fecha_larga_inicio
@endphp

@endforeach
    <body>
        <header>
            <div class="font-arial PAGADORA">@php echo $nombre_memb; @endphp</div>            
            <div class="font-arial apartado">@php echo $apartado; @endphp</div>            
            <div class="font-arial apartado">@php echo $email; @endphp</div>          
            <div class="font-arial apartado">@php echo $tel; @endphp</div>
        </header>
        <main>
            <div class="font-arial b-s16" style="text-align: center;padding-top: 30px;">CARTA OFERTA DE TRABAJO</div>
            <div class="font-arial s14" style="text-align: right;padding-top: 40px;padding-right: 50px;">@php echo "Panamá, ".$fecha_actual; @endphp</div> 
            <p>
            <div class="font-arial s14" style="text-align: left;padding-top: 30px;">@php echo $sr @endphp</div>
            <div class="font-arial b-s14" style="text-align: left;">@php echo $prinombre." ".$segnombre." ".$priapellido." ".$segapellido; @endphp</div> 
            <div class="font-arial s14" style="text-align: left;">E.    S.     M.</div></p>

            <p class="font-arial s14" style="text-align: left; padding-top: 20px;">@php echo $estimado." ".$sr." ".$priapellido @endphp</p>
            <p class="font-arial s14" style="text-align: justify; ">
                Tengo el agrado de ofrecer a usted, en nombre de <strong>@php echo $nombre_memb; @endphp</strong>, el puesto de <strong>@php echo $descpue; @endphp</strong> bajo las condiciones que se detallan a continuación:
            </p> 
            <p class="font-arial s14" style="text-align: left;">
                <ol>
                    <li><strong>Fecha de inicio: @php echo $fecha_larga_inicio; @endphp</strong></li><br>
                    <li><strong>Remuneración</strong></li>Su salario será de B/. <strong>@php echo number_format($salario, 2, '.', ','); @endphp  mensual</strong><br><br>
                    <li><strong>Plazo del nombramiento</strong></li><p style="text-align: justify;">El presente contrato será por tiempo @php echo $sel_tipo_contrato; @endphp, con un periodo probatorio de tres (3) meses. Es entendido que la compañía podrá ofrecerle en el futuro, otra posición compatible con su carrera de servicios.</p>
                </ol> 
            </p> 
<p style=" padding-top: 30px">Atentamente,</p>


<table style="border:1px" width="100%">
<tr>
    <td rowspan="2" style="width: 50%; text-align: center;">
        <div style="padding-top: 50px;">_______________________________</div>
        <div>@php echo $firmante; @endphp</div>
        <div>@php echo $puestofirmante; @endphp</div>
    </td>
    <td style="width: 50%;text-align: center;">    
        <div style="padding-top: 50px;text-align: center;">___________________________</div>
        <div style="text-align: center;">Firma de aceptación</div>
    </td>
    
    
</tr>
<tr>
    
    
    <td style="text-align: center;">

        <div style="padding-top: 20px;">___________________________</div>
        <div>Cédula</div>
    </td>
</tr>
</table>


        </main>
        <footer>
            <div style="font-size: 11px;padding-top: 80px;">CC.:	Expediente Personal</div>
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
