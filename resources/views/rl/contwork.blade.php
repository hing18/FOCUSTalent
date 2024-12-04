<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Generador de Contratos')

@section('content')
<script type="text/javascript">
    // <![CDATA[
     function preloader(){
        document.getElementById("preload").style.display = "none";
        document.getElementById("iframe").style.display = "block";
     }
     //preloader
     window.onload = preloader;
    // ]]>
  </script>

<style>  
    .mayusc{
        text-transform: uppercase;
    }
</style>
<div class="card">
  <div class="card-header pb-0">

  <h4><i class="fas fa-file-signature"></i> Generardor de Contratos</h4>

</div>
<div class="card-body">
  <small>
    <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
  </small>
    <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
    <div id="iframe" style="display: none;">
        @csrf
      <div id="div_tabla">
        <table id="MyTable" class="display compact table table-striped shadow table-bordered bg-white table-sm table-hover" style="width:100%">
          <thead class="bg-info">
            <tr>
              <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
              <th class="text-light text-center">NOMBRE</th>
              <th class="text-light text-center">PUESTO</th>
              <th class="text-light text-center">UNIDAD ECONÓMICA</th>
              <th class="text-light text-center">FECHA DE INGRESO</th>
            </tr>
          </thead>
          <tbody class="text-dark" id="bodyMyTable">           
            @foreach($data_parti as $data)
              @php
                $id_parti=$data->id_parti;
                $id_curri=$data->id_curri;
                $finicio=explode("-", $data->finicio);
                $nombre= $data->prinombre;
                if($data->segnombre!=null){ $nombre.= " ".$data->segnombre;}
                $nombre.= " ".$data->priapellido;
                if($data->segapellido!=null){ $nombre.= " ".$data->segapellido;}
              @endphp
              <tr>                
                <td class="text-center">                    
                    <i class="fas fa-search edit pr-2" onclick="show(@php echo $id_parti.','.$id_curri; @endphp)"></i>
                </td>
                <td class="text-left">{{$nombre}}</td>
                <td class="text-left">{{$data->descpue}}</td>
                <td class="text-left">{{$data->nameund}}</td>
                <td class="text-center">{{$finicio[2].'-'.$finicio[1].'-'.$finicio[0]}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
        <div id="div_detalle" style="display: none">
            <div class="row my-2">
                <section class="section profile">
                  <div class="row">
                    <div class="col-xl-4">
                      <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center mb-0">
                          <span class="align-items-center justify-content-center text-center" id="space_photo"><img src="/FOCUSTalent/public/storage/profiles/photo/el.png" alt="Profile" class="rounded-circle" id="img_photo"></span>
                          <h5 id="lb_nombre"></h5>
                          <span class="text-secondary mt-1" style="font-size: xx-small">CANDIDATO</span>
                          <button type="button" class="btn btn-sm btn-warning text-white"  onclick="document.getElementById('insert_image').click()" ><i class="far fa-id-badge fa-xl"></i> Cambiar Foto de Perfil</button>
                          <input  name="insert_image" id="insert_image" accept="image/*"  style="display: none;" type="file">
                        </div>
                        <hr class="mt-0">      
                        <div class="card-body profile-card d-flex flex-column align-items-center">
                            <a href="#" class="btn btn-sm btn-success mb-1"  onclick="gererapdfcontrato()" ><i class="fas fa-file-pdf fa-xl"></i> Generar Contrato de Trabajo</a>
                            <a href="#" class="btn btn-sm btn-primary mb-1"  onclick="finaliza_contratacion()" ><i class="fas fa-user-tie fa-xl"></i> Finalizar Proceso de Contratación</a>
                            <a href="#" class="btn btn-sm btn-secondary mb-2" onclick="back()"><i class="fas fa-arrow-left"></i> Volver</a>
                          </div>
                      </div>
                    </div>
                    <div class="col-xl-8">
                      <div class="card">
                        <div class="card-body pt-3">
                          <!-- Bordered Tabs -->
                          <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Detalle del Puesto</button>
                            </li>
                            <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Detalle del Candidato</button>
                            </li>
                            <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Documento Firmado</button>
                            </li>            
                          </ul>
                          <div class="tab-content pt-2">            
                            <!-- DETALLE DEL PUESTO -->
                            <div class="tab-pane fade show active profile-edit  profile-overview" id="profile-edit">            
                              <h5 class="card-title">Detalle del Puesto</h5>

                              <div class="row mb-2">
                                <div class="col-auto label">Posición</div>
                                <div id="lb_pos" class="col-lg-9 col-md-8 text-primary"></div>
                              </div>

                              <div class="row mb-2">
                                <div class="col-lg-4 col-md-4 label">Propósito de Puesto</div>
                                <p id="lb_proposito" class="small fst-italic">...</p>
                              </div>

                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Und. Económica</div>
                                <div id="lb_ue" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>
        
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Centro de Costo</div>
                                <div id="lb_ceco" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>

                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Pagadora</div>
                                <div id="lb_PAGADORA" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>
                              
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Salario</div>
                                <div id="lb_salario" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>
                              
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Marcación de Reloj</div>
                                <div id="lb_marcacion" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>

                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Tipo de Salario</div>
                                <div id="lb_tiposalario" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>

                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Tipo de Contrato</div>
                                <div id="lb_tipocontrato" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>
  
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">F. Ingreso</div>
                                <div id="lb_finicio" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>
   
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">F. Terminación</div>
                                <div id="lb_fterminacion" class="col-lg-9 col-md-8 mayusc"></div>
                              </div>            
                            </div>

                            <!-- DETALLE DEL CANDIDATO -->
                            <div class="tab-pane fade profile-overview" id="profile-overview">
                              
                              <h5 class="card-title">Detalle del Candidato</h5>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label ">Nombre Completo</div>
                                <div id="lb_nombre_completo" class="col-lg-9 col-md-8"></div>
                                <input type="hidden" value="" id="id_curri">     
                                <input type="hidden" value="" id="id_participante">
                                <input type="hidden" value="" id="num_aprob_ofl">
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Cédula</div>
                                <div id="lb_cedula" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label"># CSS</div>
                                <div id="lb_css" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Edad</div>
                                <div id="lb_edad" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Estado Civil</div>
                                <div id="lb_estcivil" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Teléfono</div>
                                <div id="lb_tel" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div id="lb_mail" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Nacionalidad</div>
                                <div id="lb_nacionalidad" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Dirección</div>
                                <div id="lb_dir" class="col-lg-9 col-md-8"></div>
                              </div>
            
                              <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Hoja de Vida</div>
                                <div id="lb_hv" class="col-lg-9 col-md-8"></div>
                              </div>
                              <span  id="div_permiso_trab">
                                <div class="row mb-2">
                                  <div class="col-lg-3 col-md-4 label">Permiso de Trabajo</div>
                                  <span id="lb_permiso_trabajo" class="col-lg-9 col-md-8"></span>
                                </div>
                              </span>
                            </div>

                            <!-- ADJUNTAR CONTRATO FIRMADO -->
                            <div class="tab-pane fade" id="profile-settings">
                              <h5 class="card-title">Contrato Firmado</h5>
                              <form>            
                                <span id="div_adjunta_contrato">
                                <div class="row mb-3">
                                  <label for="contwork_frim" class="col-md-auto col-form-label">Adjuntar</label>
                                    <div class="col-md-8 col-lg-9">
                                      <input class="form-control form-control-sm file" name="contwork_frim" id="contwork_frim" type="file" onchange="sube_file('contwork')" accept=".pdf,image/*">
                                    </div>
                                </div>
                                </span>
                                <div class="row mb-3">
                                <div class="col text-center" id="div_contrato_firmado" style="display: none">
                                </div></div>
                              </form><!-- End settings Form -->
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
    <div id="idformulariocontrato"></div>
    <!-- Modal -->
    <div id="insertimageModal" class="modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header py-0 bg-light">
            <h5 class="modal-title text-primary">Recortar y guardar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row ">
              <div class="col-md profile-card pt-4 d-flex flex-column align-items-center">
                <div id="image_demo" style="width:350px; margin-top:10px"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer py-0 bg-light">
            <button type="button" class="btn btn-sm btn-secondary corp_back" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
            <button class="btn btn-sm btn-primary crop_image"><i class="fas fa-cut"></i> Recortar y guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script type='text/javascript'>
    // ----- DETALLE DEL CANDIDATO
  function showfoto(id_c)
    {
      var _token = $('input[name="_token"]').val();
      $('#id_curri').val(id_c);
      var parametros = {
          "id_c":id_c,
          "_token": _token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('rl.showfoto') }}",
            type:  'POST', 
            cache: false,          
            success:  function (item) { 

              if(item.length>=20)
              {  $('#space_photo').html(item);}              
              else
              { if(item.masc_fem=='femenino'){ document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/ella.png");}
                else { document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/el.png");}}
            }
          });
    }
    function show(id_p,id_c)
    {   document.getElementById('div_tabla').style.display='none';
        document.getElementById('div_permiso_trab').style.display='none';
        document.getElementById('div_detalle').style.display='block';
        document.getElementById('num_aprob_ofl').value="";
        document.getElementById('div_adjunta_contrato').style.display='block';
        document.getElementById('div_contrato_firmado').style.display='none';
        $('#div_contrato_firmado').html('');
        document.getElementById('contwork_frim').value="";
        $('#id_curri').val(id_c);
        $('#id_participante').val(id_p);
        var _token = $('input[name="_token"]').val();
        var parametros = {
          "id_p":id_p,
          "id_c":id_c,
          "_token": _token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('rl.show') }}",
            type:  'POST', 
            dataType: "json",
            cache: false,          
            success:  function (item) { 


                var tel='No tiene'; var email='No tiene'; var provincia=''; var distrito=''; var corregimiento=''; var direccion=''; var nacionalidad=''; 
                var permiso_trab=''; var f_vence_permiso_trab=''; var permiso_doc=''; var f_nacimiento='';
                var segnombre='';  var segapellido=''; 
                if(item.segnombre!=null){segnombre=item.segnombre;}   
                if(item.segapellido!=null){segapellido=item.segapellido;}  
                nombre_completo=item.prinombre+' '+segnombre+' '+item.priapellido+' '+segapellido;

                if(item.tel!=null){tel=item.tel;}  
                if(item.email!=null){email=item.email;} 
                if(item.provincia!=null){provincia=item.provincia+', ';} 
                if(item.distrito!=null){distrito=item.distrito+', ';} 
                if(item.corregimiento!=null){corregimiento=item.corregimiento+' -';} 
                if(item.direccion!=null){direccion=item.direccion;} 

                
                if(item.nacionalidad!=null){nacionalidad=item.nacionalidad;} 

                if(item.permiso_trab!='-')
                { permiso_trab=item.permiso_trab;
                  document.getElementById('div_permiso_trab').style.display='block';
                  $('#lb_permiso_trabajo').html('<a href="'+item.premiso_doc+'" download="PERMISO-'+nombre_completo+'"><i class="fas fa-download"></i> Descargar</a>');
                } 
                $tipo_contrato='-';
                $sel_tipo_contrato= item.sel_tipo_contrato;
                if($sel_tipo_contrato=='T') { $tipo_contrato="DEFINIDO";}
                if($sel_tipo_contrato=='P') { $tipo_contrato="INDEFINIDO";}
                fechai= item.finicio.split('-');
                fterminacion="-";
                if(item.fterminacion!='1900-01-01')
                { fechat= item.fterminacion.split('-');
                  fterminacion=fechat[2]+'-'+fechat[1]+'-'+fechat[0];
                }

                $('#lb_PAGADORA').html(item.nombre_memb);
                $('#lb_ue').html(item.nameund);
                $('#lb_nombre').html(item.prinombre+' '+item.priapellido);
                $('#lb_nombre_completo').html(nombre_completo);
                $('#lb_tel').html(tel);
                $('#lb_mail').html(email);
                $('#lb_nacionalidad').html(nacionalidad);
  
                $('#lb_cedula').html(item.cedula);
                $('#lb_css').html(item.num_ss);
                $('#lb_edad').html(item.anios);
                $('#lb_estcivil').html(item.estadocivil)+"(a)";
                $('#lb_dir').html(provincia+" "+distrito+" "+corregimiento+" "+direccion);
                $('#lb_hv').html('<a href="'+item.cv_doc+'" download="CV-'+nombre_completo+'"><i class="fas fa-download"></i> Descargar</a>');
                $('#lb_ceco').html(item.centro_costo);
                $('#lb_pos').html(item.descpue);
                $('#lb_tipocontrato').html($tipo_contrato);
                $('#lb_finicio').html(fechai[2]+'-'+fechai[1]+'-'+fechai[0]);
                $('#lb_fterminacion').html(fterminacion);
                $('#lb_salario').html(item.sal);
                $('#lb_tiposalario').html(item.tiposalario);
                $('#lb_proposito').html(item.proposito);
                $('#num_aprob_ofl').val(item.num_aprob_ofl);          
                if(item.contworkfirmado!=null)
                { document.getElementById('div_adjunta_contrato').style.display='none';
                  document.getElementById('div_contrato_firmado').style.display='block';
                  fecha= item.f_contworkfirmado.split('-');
                  $('#div_contrato_firmado').html('<a href="'+item.contworkfirmado+'" download="Contrato Firmado - '+item.prinombre+' '+item.priapellido+'"><i class="fas fa-download"></i> Descargar <b>Contrato Firmado</b>. ('+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+')</a> <i title="Eliminar archivo de contrato firmado" class="fa-solid fa-trash-can dell" onclick=deldocont("'+item.num_aprob_ofl+'")></i>');
                }
                $('#lb_marcacion').html('NO');
                if(item.marcacion==1)
                {
                  $('#lb_marcacion').html('SI');
                }

                showfoto(id_c)
            }
          });

    }

    function back()
    {   document.getElementById('div_tabla').style.display='block';
        document.getElementById('div_detalle').style.display='none';
        document.getElementById('div_permiso_trab').style.display='none';
        document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/el.png");
    }

    function gererapdfcontrato()
    { 
        $("#idformulariocontrato").html('');
        var form = $("<form/>", 
        {   action:"{{ route('ofertas.cartapdfcontrato') }}" , 
            method : 'POST',
            id:'from_contwork'}
          );
        form.append( $("<input>", { type :'hidden', id  :  'id_curri_cont',  name :'id_curri_cont',  value: $('#id_curri').val() } ));
        form.append( $("<input>", { type :'hidden', id  :  'id_participante_cont',  name :'id_participante_cont',  value: $('#id_participante').val() } ));
        form.append( $("<input>",  { type  :'hidden', id   :'tok_cont', name  :'tok_cont', value : $('input[name="_token"]').val() }));
        form.append( $("<input>", { type :'hidden', id  :  'opt_cont',  name :'opt_cont',  value: 0 } ));
        form.append('@csrf');
        $("#idformulariocontrato").append(form);

        var _token = $('input[name="_token"]').val();
        var parametros = {
        "id_participante_cont" : $('#id_participante').val(),
        "opt_cont" : 1 ,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('ofertas.cartapdfcontrato') }}",
          type:  'POST', 
          cache: true,       
          beforeSend: function () {
            //  document.getElementById("ico_"+id).innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
              from_contwork.submit();
            }, 
          success:  function (data) {  
            if(data==1)        
            {  
            //  document.getElementById('div_cartaoferta_aprobacion').style.display='block';
            /*  document.getElementById('div_autorizacioncarta_ofl').style.display='block';
              document.getElementById("ico_"+id).innerHTML='<i class="fas fa-download fa-lg activar" onclick="gererapdf('+id+')"></i>';*/
            }
          }
        });
  }

    //----- SUBRE ARCHIVOS A STORAGE
  function sube_file(optarchi)
  { var _token = $('input[name="_token"]').val();

   // $("#tipo_archi").val(optarchi);
    if(optarchi=='contwork')
    {    
      var file= document.getElementById('contwork_frim').files;
      filefirmado = file[0];
      var data = new FormData();    
      data.append("_token", _token); 
      data.append("optarchi", optarchi);
      data.append("filedoc", filefirmado);
      data.append("num_aprob_ofl", $('#num_aprob_ofl').val());
      $.ajax({
        data:  data, 
        url:   "{{ route('ofertas.subir') }}",
        type:  'POST',//método de envio
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,			// To send DOMDocument or non processed data file it is set to false+
        dataType: "json",
        beforeSend: function () {
          document.getElementById('div_adjunta_contrato').style.display="none";
          $('#div_contrato_firmado').html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
          document.getElementById('div_contrato_firmado').style.display="block";
        }, 
        success:  function (data) {

          //  document.getElementById('div_cartaoferta_aprobacion').style.display='block';
            document.getElementById('div_adjunta_contrato').style.display='block';
            document.getElementById('div_contrato_firmado').style.display='none';
            document.getElementById('contwork_frim').value="";
          if(data!='-')
          { fecha= data.f_contworkfirmado.split('-');
            document.getElementById('div_adjunta_contrato').style.display="none";
            document.getElementById('div_contrato_firmado').style.display="block";
            $('#div_contrato_firmado').html('<a href="'+data.url+'" download="Contrato Firmado - '+$('#lb_nombre').html()+'"><i class="fas fa-download"></i> Descargar <b>Contrato Firmado</b>. ('+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+')</a> <i title="Eliminar archivo de contrato firmado" class="fa-solid fa-trash-can dell" onclick=deldocont("'+$('#num_aprob_ofl').val()+'")></i>');
          }
        }
      });
    }
 }
  //----- MENSAJE GENERICO SI ALGO SALE MAL, SE ENVIA EL MENSAJE EN EL PARAMETRO
  function mal(msn)
  {
      Swal.fire({
        position: 'center',
        icon: 'warning',
        text: msn,
      })
  }
    //----- MENSAJE GENERICO SI ALGO SALE BIEN, SE ENVIA EL MENSAJE EN EL PARAMETRO
  function bien(msn)
  {
    Swal.fire({
    position: 'center',
    icon: 'success',
    text: msn,
    showConfirmButton: false,
    timer: 2000
    })
  }
 
  function finaliza_contratacion()
  { var _token = $('input[name="_token"]').val();
    var id_c = $('#id_curri').val();
    var id_p = $('#id_participante').val();
    alert(id_p);
    
  }

</script>