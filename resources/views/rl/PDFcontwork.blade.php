<!doctype html>
<html lang="en">
    <head>
        <title>Contrato de Trabajo</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
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
@php
    $fecha_larga_terminacion = ($data['sel_tipo_contrato'] ?? '') != 'P' ? " al <strong>" . ($data['fterminacion_largo'] ?? '') . "</strong>" : "";
     $sal= number_format($data['salario'], 2, '.', ',')." (por mes)";
    if($data['sel_tipo_salario']=='H'){   $sal= number_format(($data['salario']/$data['hrs_mensuales']), 2, '.', ',')." (por hora)";  }
@endphp
    <body>
        <header>
            <div class="font-arial PAGADORA">CONTRATO DE TRABAJO</div>
        </header>
        <main>
                <p class="font-arial s14" style="text-align: justify;  padding-top: 25px;">

                En la ciudad de Panamá, a los <strong>{{ $data['fecha_actual'] }}</strong>, la Empresa <strong> <span class="mayusc">{{ $data['nombre_memb'] }}</span></strong>, {{ $data['detalle'] }}, <strong><span class="mayusc">{{ $data['representante'] }}</span></strong>, {{ $data['det_representante'] }}, domiciliada en Calle 50, Plaza
                    Panamá, Piso 24, de esta ciudad, con cédula de identidad personal No. {{ $data['ced_representante'] }},
                por una parte y por la otra,  <strong> <span class="mayusc">{{ $data['prinombre'] }} {{ $data['segnombre'] }} {{ $data['priapellido'] }} {{ $data['segapellido'] }}</span></strong>, de sexo {{ $data['masc_fem'] }}, 
                nacionalidad 
                {{ $data['nacionalidad'] }}, con  {{ $data['anios'] }} años, {{ $data['estadocivil'] }}, domiciliado en, 
                {{ $data['provincia'] }}, 
                {{ $data['distrito'] }}, 
                {{ $data['corregimiento'] }}, 
                {{ $data['direccion'] }}, 
                portador {{ $data['tipo_doc'] }} y Seguro Social  N°. {{ $data['num_ss'] }}, en su propio nombre y que en adelante se denominará EL TRABAJADOR, han convenido celebrar, como en efecto celebran, el siguiente contrato:
                </p>
            
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>PRIMERO:</u></strong>	
                    Al tenor de lo dispuesto en el ordinal 2 del artículo 68 del Código de  Trabajo de la República de Panamá, 
                    EL TRABAJADOR, deja constancia expresa de que las siguientes personas viven con él:
                </p>
                <div class="font-arial s14" style=" padding-left: 20px;" aria-hidden="true">

                    <table width='95%' CELLPADDING='2' CELLSPACING='2'>
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>PARENTESCO</th>
                                <th>F. NACIMIENTO</th>
                                <th>EDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($data['dependientes']) && count($data['dependientes']) > 0)
                                @foreach ($data['dependientes'] as $item)
                                    @php
                                        $cumpleanos = new DateTime($item['f_nacimiento']);
                                        $hoy = new DateTime();
                                        $annos = $hoy->diff($cumpleanos);
                                    @endphp
                                    <tr>
                                        <td>{{ $item['nombre'] }}</td>
                                        <td style="text-align: center;">{{ $item['parentesco'] }}</td>
                                        <td style="text-align: center;">{{ $item['f_nacimiento'] }}</td>
                                        <td style="text-align: center;">{{ $annos->y }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No tiene dependientes</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <p class="font-arial s14" style="text-align: justify; padding-top: 20px;">
                    <strong><u>SEGUNDO:</u></strong>	
                    EL TRABAJADOR se compromete a prestar servicios a LA COMPAÑÍA en calidad de <strong>{{ $data['puesto'] }}</strong> y estará obligado a: 
                    {{ $data['proposito'] }}. En general ejecutar todas las <strong>funciones análogas</strong>, complementarias o accesorias de la posición mencionada 
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
                    El presente contrato es por tiempo <strong><span class="mayusc">{{ $data['tipo_contrato'] }}</span></strong>, a partir del 
                    <strong> {{ $data['fecha_larga_inicio'] }}</strong>@php echo $fecha_larga_terminacion; @endphp, en calidad de <strong>{{ $data['puesto'] }}</strong>. Queda entendido que los tres (3) 
                    primeros meses serán de prueba, y que en el transcurso de este periodo cualquiera de las partes puede dar por terminada la relación de trabajo,
                     sin responsabilidad para ninguna de ellas.
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>QUINTO:</u></strong>	
                    La duración de la jornada de trabajo será de {{ $data['hrs_semanales'] }} horas semanales (8 horas diarias), La jornada laboral será establecida por el Jefe inmediato y según las necesidades de la Empresa. Dichas jornadas, se dividirán como regla general en un periodo rotativo a saber: 
                </p>
                
                    <div class="font-arial s14" style=" padding-left: 60px;" aria-hidden="true">@php echo $data['horarios']; @endphp</div>
                
                <p class="font-arial s14" style="text-align: justify;">
                    También trabajará los domingos, cuando fuese necesario, según el criterio de <strong>EL EMPLEADOR</strong>, pagaderos conforme lo establece el artículo 48 del Código de Trabajo 	
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>SEXTO:</u></strong>	
                    LA COMPAÑÍA pagará a EL TRABAJADOR, como remuneración por el trabajo efectuado el sueldo o salario de <strong>B/.@php echo $sal; @endphp</strong>. Dicho pago será efectivo los días 15 y 30 de cada mes, en cheque en las instalaciones en donde labore EL TRABAJADOR.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    El salario se pagará debidamente AL TRABAJADOR una vez hechas las deducciones y retenciones requeridas o autorizadas por la ley. 
                    EL TRABAJADOR se obliga a no ceder, traspasar, gravar, enajenar total o parcialmente su sueldo o salario a terceras personas.
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>OCTAVO:</u></strong>	
                    EL TRABAJADOR sólo podrá trabajar horas extraordinarias con el consentimiento previo y por escrito de LA EMPRESA, las cuales se computarán conforme al artículo 33 del Código de Trabajo.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>NOVENO:</u></strong>	
                    EL TRABAJADOR acepta que, durante la vigencia de este contrato, no prestará sus servicios a ninguna otra persona natural o jurídica además de LA EMPRESA, ni se dedicará a ninguna industria o negocio por cuenta propia o ajena.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>DECIMO:</u></strong>	
                    EL TRABAJADOR	 declara que se encuentra en buen Estado de Salud, el cual se anexa a este contrato y forma parte integrante del mismo.                
                </p>
                <p class="font-arial s14" style="text-align: justify;">
                    <strong><u>UNDECIMO:</u></strong>	
                    Las partes contratantes quedan sujetas a la obligación que consigna el Código de Trabajo, sus reglamentos y las estipulaciones que confieren el Reglamento Interno de Trabajo debidamente aprobado por el Ministerio de Trabajo y Desarrollo Laboral.                
                </p>
                <p>
                <p class="font-arial s14" style="text-align: justify;">
                    En fe de lo anteriormente estipulado, las partes de Mutuo Acuerdo firman el presente Contrato de Trabajo, en la ciudad de Panamá, a los <strong>{{ $data['fecha_actual'] }}</strong>.              
                </p>
<!-- FIRMAS -->
        <table style="border:1px; padding-top: 70px;" width="100%">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="text-align: center;"><strong> <span class="mayusc">{{ $data['nombre_memb'] }}</span></strong></div>
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
                <div><strong> <span class="mayusc">{{ $data['representante'] }}</span></strong></div>
                <div> <span >Cédula No. {{ $data['ced_representante'] }}</span></div>
            </td>
            <td style="text-align: center;">

                <div style="padding-top: 30px;">_______________________________________</div>
                <div><strong> <span class="mayusc">{{ $data['prinombre'] }} {{ $data['segnombre'] }} {{ $data['priapellido'] }} {{ $data['segapellido'] }}</span></strong></div>
                <div> <span>{{ $data['tipo_doc_firma'] }}</span></div>
            </td>
        </tr>
        </table>
        </p>
        </main>

    </body>
</html>
