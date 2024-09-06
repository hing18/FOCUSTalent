<!doctype html>
<html lang="en">
    <head>
        <title>Contrato de Trabajo</title>
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
        font-size: 14px;
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
    .mayusc{
        text-transform: uppercase;
    }
    .minusc{
        text-transform: lowercase;
    }
    .capital{

        text-transform: capitalize !important;
    }
</style>

@php    $array[] =  json_decode($data);

 @endphp
@foreach ($array as $item)
@php
    $fecha_actual= $item->fecha_actual;
    $nombre_memb= $item->nombre_memb;
    $representante= $item->representante;
    $ced_representante= $item->ced_representante;
    $det_representante= $item->det_representante;
    $detalle= $item->detalle;
    $prinombre= $item->prinombre;
    $segnombre= $item->segnombre;
    $priapellido= $item->priapellido;
    $segapellido= $item->segapellido;
    $masc_fem=$item->masc_fem;
    $nacionalidad = $item->nacionalidad;
    $direccion = $item->direccion;
    $provincia  = $item->provincia;
    $distrito  = $item->distrito;
    $corregimiento = $item->corregimiento;
    $anios = $item->anios;
    $tipo_doc = $item->tipo_doc;
    $tipo_doc_firma = $item->tipo_doc_firma;
    $descpue = $item->descpue;
    $proposito=$item->proposito;

    $tipo_contrato=$item->tipo_contrato;
    $fecha_larga_inicio= $item->fecha_larga_inicio;
    $fecha_larga_terminacion="";
    if($item->sel_tipo_contrato!='P')
    { $fecha_larga_terminacion= " al <strong>".$item->fecha_larga_terminacion."</strong>";}
    $dependientes = $item->dependientes;
    $hrs_semanales= $item->hrs_semanales; 
    $hrs_mensuales= $item->hrs_mensuales; 
    $horarios= $item->horarios;
    $salario= $item->salario;
    $num_ss= $item->num_ss;
    $estadocivil= $item->estadocivil." (a)";
    $sal= number_format($salario, 2, '.', ',')." (por mes)";
    if($item->sel_tipo_salario=='H'){
        
        $sal= number_format(($salario/$hrs_mensuales), 2, '.', ',')." (por hora)";    
    }
@endphp

@endforeach
    <body>
        <header>
            <div class="font-arial PAGADORA">CONTRATO DE TRABAJO</div>
        </header>
        <main>
                <p class="font-arial s14" style="text-align: justify;  padding-top: 25px;">

                En la ciudad de Panamá, a los <strong>@php echo $fecha_actual; @endphp</strong>, la Empresa <strong> <span class="mayusc">@php echo $nombre_memb; @endphp</span></strong>, @php echo $detalle; @endphp 
                , <strong><span class="mayusc">@php echo $representante; @endphp</span></strong>, @php echo $det_representante; @endphp, domiciliada en Calle 50, Plaza
                    Panamá, Piso 24, de esta ciudad, con cédula de identidad personal No. @php echo $ced_representante; @endphp,
                por una parte y por la otra,  <strong> <span class="mayusc">@php echo $prinombre." ".$segnombre." ".$priapellido." ".$segapellido; @endphp</span></strong>, de sexo @php echo $masc_fem; @endphp, 
                nacionalidad 
                @php echo $nacionalidad @endphp, con  @php echo $anios @endphp  años, @php echo $estadocivil @endphp, domiciliado en, 
                @php echo $provincia @endphp, 
                @php echo $distrito @endphp, 
                @php echo $corregimiento @endphp, 
                @php echo $direccion @endphp, 
                portador @php echo $tipo_doc @endphp y Seguro Social  N°.  @php echo $num_ss @endphp, en su propio nombre y que en adelante se denominará EL TRABAJADOR, han convenido celebrar, como en efecto celebran, el siguiente contrato:
                </p>
            
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>PRIMERO:</u></strong>	
                    Al tenor de lo dispuesto en el ordinal 2 del artículo 68 del Código de  Trabajo de la República de Panamá, 
                    EL TRABAJADOR, deja constancia expresa de que las siguientes personas viven con él:
                </p>
                <div class="font-arial s14" style=" padding-left: 20px;" aria-hidden="true">
                <table width='95%' CELLPADDING='2' CELLSPACING='2'><tr><td>
                  <strong> NOMBRE </strong></td><td><strong> PARENTESCO</strong></td><td><strong>F. NACIMIENTO</strong></td><td><strong>EDAD</strong></td><td>
                    @if(count($dependientes)>1)                   
                        @foreach ($dependientes as $item)
                        <tr><td>
                            @php    $cumpleanos = new DateTime($item->f_nacimiento);
                                $hoy = new DateTime();
                                $annos = $hoy->diff($cumpleanos);                            
                                echo  $item->nombre;@endphp
                        </td><td>
                            @php echo $item->parentesco; @endphp
                        </td><td>
                            @php echo $item->f_nacimiento; @endphp
                        </td><td>
                            @php echo $annos->y; @endphp
                        </td><td>
                        @endforeach
                  
                    @else
                        <tr><td colspan='4'>No tiene dependientes</td></tr>
                    @endif
                    </table>
                </div>

                <p class="font-arial s14" style="text-align: justify; padding-top: 20px;">
                    <strong><u>SEGUNDO:</u></strong>	
                    EL TRABAJADOR se compromete a prestar servicios a LA COMPAÑÍA en calidad de <strong>@php echo $descpue @endphp</strong> y estará obligado a realizar:
                    @php echo $proposito @endphp. En general ejecutar todas las <strong>funciones análogas</strong>, complementarias o accesorias de la posición mencionada 
                    en aquellas dependencias que LA COMPAÑÍA señale.
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>TERCERO:</u></strong>	
                    EL TRABAJADOR, prestará sus servicios en las dependencias de LA COMPAÑÍA, queda establecido que LA COMPAÑÍA podrá trasladar AL TRABAJADOR en el desempeño 
                    de sus mismos servicios y deberes, a cualquier de sus dependencias en la República de Panamá, sin que tal traslado constituya ni interrupción de los servicios 
                    ni suspensión total o parcial del presente contrato de trabajo.
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>CUARTO:</u></strong>	
                    El presente contrato es por tiempo <strong><span class="mayusc">@php echo  $tipo_contrato; @endphp</span></strong>, a partir del 
                    <strong> @php echo $fecha_larga_inicio; @endphp</strong>@php echo $fecha_larga_terminacion; @endphp, en calidad de <strong>@php echo $descpue @endphp</strong>. Queda entendido que los tres (3) 
                    primeros meses serán de prueba, y que en el transcurso de este periodo cualquiera de las partes puede dar por terminada la relación de trabajo,
                     sin responsabilidad para ninguna de ellas.
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>QUINTO:</u></strong>	
                    La duración de la jornada de trabajo será de @php echo $hrs_semanales; @endphp horas semanales (8 horas diarias), La jornada laboral será establecida por el Jefe inmediato y 
                    según las necesidades de la Empresa. Dichas jornadas, se dividirán como regla general en un periodo rotativo a saber: 
                </p>
                
                    <div class="font-arial s14" style=" padding-left: 60px;" aria-hidden="true">@php echo $horarios; @endphp</div>
                
                <p class="font-arial s14" style="text-align: justify;">
                    También trabajará los domingos, cuando fuese necesario, según el criterio de <strong>EL EMPLEADOR</strong>, pagaderos conforme lo establece el artículo 48 del Código de Trabajo	
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>SEXTO:</u></strong>	
                    LA COMPAÑÍA pagará a EL TRABAJADOR, como remuneración por el trabajo efectuado el sueldo o salario de <strong>B/.@php echo $sal; @endphp</strong>. Dicho pago será 
                    efectivo los días 15 y 30 de cada mes, en cheque en las instalaciones en donde labore EL TRABAJADOR.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    El salario se pagará debidamente AL TRABAJADOR una vez hechas las deducciones y retenciones requeridas o autorizadas por la ley. 
                    EL TRABAJADOR se obliga a no ceder, traspasar, gravar, enajenar total o parcialmente su sueldo o salario a terceras personas.
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>OCTAVO:</u></strong>	
                    EL TRABAJADOR sólo podrá trabajar horas extraordinarias con el consentimiento previo y por escrito de LA EMPRESA, las cuales se 
                    computarán conforme al artículo 33 del Código de Trabajo.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>NOVENO:</u></strong>	
                    EL TRABAJADOR acepta que, durante la vigencia de este contrato, no prestará sus servicios a ninguna otra persona natural o 
                    jurídica además de LA EMPRESA, ni se dedicará a ninguna industria o negocio por cuenta propia o ajena.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>DECIMO:</u></strong>	
                    EL TRABAJADOR	 declara que se encuentra en buen Estado de Salud, el cual se anexa a este contrato y forma parte integrante del mismo.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>UNDECIMO:</u></strong>	
                    Las partes contratantes quedan sujetas a la obligación que consigna el Código de Trabajo, sus reglamentos y las estipulaciones que 
                    confieren el Reglamento Interno de Trabajo debidamente aprobado por el Ministerio de Trabajo y Desarrollo Laboral.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    En fe de lo anteriormente estipulado, las partes de Mutuo Acuerdo firman el presente Contrato de Trabajo, en la ciudad de Panamá, a los <strong>@php echo $fecha_actual; @endphp</strong>.              
                </p>


<!-- FIRMAS -->
        <table style="border:1px; padding-top: 70px;" width="100%">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="text-align: center;"><strong> <span class="mayusc">@php echo $nombre_memb; @endphp</span></strong></div>
                <div></div>
                <div></div>
            </td>
            <td style="width: 50%;text-align: center;">    

                <div style="text-align: center;"><strong>EL TRABAJADOR</strong></div>
                <div></div>
                <div></div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <div style="padding-top: 30px;">_______________________________________</div>
                <div><strong> <span class="mayusc">@php echo $representante; @endphp</span></strong></div>
                <div> <span >Cédula No. @php echo $ced_representante; @endphp</span></div>
            </td>
            <td style="text-align: center;">

                <div style="padding-top: 30px;">_______________________________________</div>
                <div><strong> <span class="mayusc">@php echo $prinombre." ".$segnombre." ".$priapellido." ".$segapellido; @endphp</span></strong></div>
                <div> <span>@php echo $tipo_doc_firma; @endphp</span></div>
            </td>
        </tr>
        </table>
        </main>
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
