<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','empleados')

@section('content')
<!-- JavaScript -->
<script type="text/javascript">
    // <![CDATA[
     function preloader(){
        document.getElementById("preload").style.display = "none";
        document.getElementById("iframe").style.display = "block";
    // <!    document.getElementById("div_2").style.display = "block";
     }
     //preloader
     window.onload = preloader;
    // ]]>
    </script>
    
    <!-- Estilo -->
    <style>
      div#iframe { display: none; }
      div#preload { cursor: wait; }
      #img_photo:hover {filter: sepia(75%);}      
    </style>
    
<div class="card">
    <div class="card-header pb-0">
      <h4><i class="fas fa-users"></i> Maestro de Empleados</h4>
    </div>
    <div class="card-body">
      <small>
        <div id="preload" class="align-items-center justify-content-center text-center mt-4"><div class="spinner-border text-primary" role="status"></div></div>
      </small>
        <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
        <div id="iframe" style="display: none;">
            <!-- TABLA PRINCIPAL LISTADO DE EMPLEADOS-->
            <div id="div_tabla_listado">     
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">       
                <button type="button" class="btn btn-primary btn-sm" onclick="modalcrud(1,0)"><i class="fas fa-plus pe-2"></i> Nuevo</button>
                </div>
                <div id="iframe" style="display: block;">
                    <table id="MyTable" class="table table-striped table-hover shadow table-bordered bg-white table-sm" style="width:100%">
                    <thead class="bg-info">
                        <tr>
                        <th class="text-light text-center" >CODIGO</th>
                        <th class="text-light text-center" >NOMBRE</th>
                        <th class="text-light text-center" >POSICIÓN</th>
                        <th class="text-light text-center" >DEPARTAMENTO</th>
                        <th class="text-light text-center" >UNIDAD</th>
                        <th class="text-light text-center" width='10%'><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody class="text-dark" id="bodyMyTable_empleados">
                        @foreach($empleados as $empleado )
                        <tr>
                            <td class=" text-center">{{$empleado->id}}</td>
                            <td class="text-uppercase"><span id="nom_{{$empleado->id}}">{{$empleado->prinombre}} {{$empleado->priapellido}}</span></td>
     
                            <td class="text-uppercase">{{$empleado->descpue}}</td>
                            <td class="text-uppercase">{{$empleado->uni}}</td>
                            <td class="text-uppercase">{{$empleado->ue}}</td>
                            <td>
                                <div class="row d-flex align-items-center justify-content-center text-center">
                                    <div class="col-sm-1 text-secondary">
                                        <i class="fas fa-search fa-lg edit" title="Editar" onclick="ver({{$empleado->id}})"></i>  
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>

            <div id="div_tabla_detalle" class="visually-hidden">
                <div class="row justify-content-start">        
                    @csrf            
                    <div class="row pt-4 justify-content-between">
                        <div class="col-4 d-flex flex-column justify-content-center align-items-center text-center">
                          <span class=" d-flex justify-content-center align-items-center" style="cursor: pointer; width: 120px; height: 120px;" onclick="document.getElementById('insert_image_emplo').click()" id="space_photo"> </span>
                          <input name="insert_image_emplo" id="insert_image_emplo" accept="image/*" style="display: none;" type="file"> 

                          <h6 id="lb_nombre" class="fw-bold mb-0 pt-1 text-primary"></h6>
                          <div id="lb_codigo" class="text-secondary small mt-0 pb-1"></div>
                      </div>



                        <div class="col-4 text-center" style="vertical-align: middle;">
                            <div class="mt-4 pt-4 mb-0 d-flex flex-column align-items-end">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="back()"><i class="fas fa-arrow-left"></i> Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row pt-4">                
                    <div class="col-12">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs">
                              <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1">Información Personal</button>
                              </li>
                              <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2">Datos Laborales</button>
                              </li>
                              <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab3">Salario y Beneficios</button>
                              </li>  
                              <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab4">Contactos</button>
                              </li>
                              <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab5">Expediente</button>
                              </li>
                            </ul>
                            <div class="tab-content pt-2">            
                                <!-- INFORMACIÓN PERSONAL -->
                                <div class="tab-pane fade show active p-4" id="tab1">   
                                  <small>  
                                    <div class="row pb-4">       
                                      <h5 class="py-2 text-primary" style=" background-color: #D4DCEB; border-radius: 10px 10px 0px 0px;"><i style="color:#37517E;" class="fas fa-user-tag"></i>  Datos Personales del Colaborador</h5> 
                                     
                                      <div class="row mb-3">
                                        <div class="col-md">
                                          <label for="prinombre" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Primer nombre:</label>
                                          <input type="text" class="form-control form-control-sm" id="prinombre" name="prinombre" value="">
                                        </div>
                                        <div class="col-md">
                                          <label for="segnombre" class="form-label form-label-sm">Segundo nombre:</label>
                                          <input type="text" class="form-control form-control-sm" id="segnombre" name="segnombre" value="">
                                        </div>
                                        <div class="col-md">
                                          <label for="priapellido" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Primer apellido:</label>
                                          <input type="text" class="form-control form-control-sm" id="priapellido" name="priapellido" value="">
                                        </div>
                                        <div class="col-md">
                                          <label for="segapellido" class="form-label form-label-sm">Segundo apellido:</label>
                                          <input type="text" class="form-control form-control-sm" id="segapellido" name="segapellido" value="">
                                        </div>
                                      </div>

                                      <div class="row mb-3">
                                        <div class="col-md-3 mt-4 pt-2">
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sel_genero[]" id="genero_M" value="M" checked>
                                            <label class="form-check-label" for="genero_M">Masculino</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sel_genero[]" id="genero_F" value="F">
                                            <label class="form-check-label" for="genero_F">Femenino</label>
                                          </div>
                                        </div>  
                                        <div class="col-md-3">
                                          <label for="f_nacimiento" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Fecha de nacimiento:</label>
                                          <input type="date" class="form-control form-control-sm" id="f_nacimiento" name="f_nacimiento">
                                        </div>
                                        <div class="col-md-3">
                                          <label for="sel_estadocivil" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Estado civil:</label>
                                          <select class="form-select form-select-sm" name="sel_estadocivil" id="sel_estadocivil">
                                            <option selected value='-'>Seleccionar</option>
                                            <option value="casado">CASADO (A)</option>
                                            <option value="soltero">SOLTERO (A)</option>
                                            <option value="unido">UNIDO (A)</option>
                                            <option value="divorciado">DIVORCIADO (A)</option>
                                            <option value="separado">SEPARADO (A)</option>
                                            <option value="viudo">VIUDO (A)</option>
                                          </select>
                                        </div>
                                      </div>


                               
                                      <div class="row mb-3">
                                        <div class="col-md-3 mt-4 pt-2">
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nacext[]" id="nacext_N" value="N" checked  onclick="showpermiso()">
                                            <label class="form-check-label" for="nacext_N">Nacional</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nacext[]" id="nacext_E" value="E" onclick="showpermiso()">
                                            <label class="form-check-label" for="nacext_E">Extranjero </label>
                                          </div>
                                        </div>
                                        <div class="col-md-3">
                                          <label for="sel_nacionalidad" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Pais de nacimiento:</label>
                                          <select class="form-select form-select-sm" name="sel_nacionalidad" id="sel_nacionalidad">
                                            <option selected value='0'>Seleccionar</option>
                                              @foreach( $data_nacionalidades as $nacionalidades )
                                                <option value="{{ $nacionalidades->id }}">{{ $nacionalidades->pais}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                      
                                    <div class="row py-4">       
                                      <h5 class="py-2 text-primary" style=" background-color: #D4DCEB; border-radius: 10px 10px 0px 0px;"><i style="color:#37517E;" class="far fa-id-card"></i> Datos de Identificación</h5>
                                      <div class="row mb-3">
                                        <div class="col-md-3">
                                          <label for="sel_tipodoc" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Tipo de documento:</label>
                                          <select class="form-select form-select-sm" name="sel_tipodoc" id="sel_tipodoc">
                                              @foreach( $data_tipo_documento as $tipo_documento )
                                                <option value="{{ $tipo_documento->letra }}">{{ $tipo_documento->tipodoc}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="num_docip" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Número de documento:</label>
                                            <input type="text" class="form-control form-control-sm" id="num_docip" name="num_docip" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="f_vencimiento_docip" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Vencimiento del documento:</label>
                                            <input type="date" class="form-control form-control-sm" id="f_vencimiento_docip" name="f_vencimiento_docip">
                                        </div>                                        
                                        <div class="col-md-3">
                                          <label for="num_ss" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Número de seguro social:</label>
                                          <input type="text" class="form-control form-control-sm" id="num_ss" name="num_ss" value="">
                                        </div>
                                      </div>
                                    </div>
                                      
                                    <div class="row py-4">       
                                      <h5 class="py-2 text-primary" style=" background-color: #D4DCEB; border-radius: 10px 10px 0px 0px;"><i style="color:#37517E;" class="fas fa-address-book"></i> Datos de Contacto</h5>
                                      <div class="row mb-3">
                                        <div class="col-md-3">
                                          <label for="telefono" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Teléfono:</label>
                                          <input type="tel" class="form-control form-control-sm" id="telefono" name="telefono" value="">
                                        </div>                                        
                                        <div class="col-md-3">
                                          <label for="mail" class="form-label form-label-sm">Correo electrónico:</label>
                                          <input type="email" class="form-control form-control-sm" id="mail" name="mail" value="">
                                        </div>
                                      </div>

                                      <div id="div_permiso_trab" style="display:none">
                                        <div class="row mb-3">
                                          <div class="col-md-3 align-middle">
                                            <label for="sel_tipopermiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Permiso de trabajo:</label>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_tipopermiso" id="sel_tipopermiso">
                                              <option selected value='0'>Seleccionar</option>
                                                @foreach( $data_tipo_permiso as $tipo_permiso )
                                                  <option value="{{ $tipo_permiso->id }}">{{ $tipo_permiso->tipopermiso}}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                          
                                          <div class="col-md-auto mt-4 pt-2">
                                            <a href="info/PERMISOS DE TRABAJO AUTORIZADOS POR MITRADEL.pdf" download="PERMISOS DE TRABAJO AUTORIZADOS POR MITRADEL.pdf"><i class="far fa-file-pdf fa-2x editlink" title="Descargar documento de permisos de trabajo"></i></a>
                                          </div>
                                          <div class="col-md-3">
                                              <label for="f_vence_permiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Vencimiento del permiso:</label>
                                              <input type="date" class="form-control form-control-sm" id="f_vence_permiso" name="f_vence_permiso">
                                          </div>                    
                                          <div class="col-4">
                                              <label for="filepermiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Adjuntar permiso de trabajo:</label>
                                              <input class="form-control form-control-sm" name="filepermiso" id="filepermiso" type="file" accept=".doc,.pdf,image/*">
                                          </div>
                                        </div>
                                      </div>                                  
                                    </div>

                                      
                                    <div class="row py-4">       
                                      <h5 class="py-2 text-primary" style=" background-color: #D4DCEB; border-radius: 10px 10px 0px 0px;"><i style="color:#37517E;" class="fas fa-wheelchair"></i> Discapacidad</h5>
                                      <div class="row mb-3">
                                        <div class="col-md-2 align-middle">
                                          <label for="sel_discapacidad" class="form-label form-label-sm" id="lb_docip"> Posee alguna discapacidad?</label>
                                          <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_discapacidad" id="sel_discapacidad">
                                            <option selected value='NO'>NO</option>
   
                                          </select>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="explique_disc" class="form-label form-label-sm"> Discapacidad específica:</label>
                                          <input class="form-control form-control-sm" type="text" id="explique_disc" name="explique_disc" value="">
                                        </div>
                                      </div>                                 
                                    </div>


                                  </small>         
                                </div>
    
                                <!-- DETALLE DEL CANDIDATO -->
                                <div class="tab-pane fade" id="tab2">                                
                                    2222
                                </div>
  
                                <!-- ADJUNTAR CONTRATO FIRMADO -->
                                <div class="tab-pane fade" id="tab3">  
                                    33333
                                </div>

                                <!-- DETALLE DEL CANDIDATO -->
                                <div class="tab-pane fade" id="tab4">                                
                                    4444
                                </div>
  
                                <!-- DETALLE DEL CANDIDATO -->
                                <div class="tab-pane fade" id="tab5">                                
                                    5555
                                </div>
                            </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                  <div id="image_demo_emplo" style="width:350px; margin-top:10px"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer py-0 bg-light">
              <button type="button" class="btn btn-sm btn-secondary corp_back" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
              <button class="btn btn-sm btn-primary crop_image_emplo"><i class="fas fa-cut"></i> Recortar y guardar</button>
            </div>
          </div>
        </div>
      </div>
@endsection
<script type='text/javascript'>
    function ver(cod)
    {   $('#div_tabla_listado').addClass('visually-hidden');
        $('#div_tabla_detalle').removeClass('visually-hidden');
        $('#lb_nombre').html($('#nom_'+cod).html());
        $('#lb_codigo').html(cod);
        var parametros = {
          "cod" : cod,
          "_token":$('input[name="_token"]').val()};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('empleados.employee') }}",
            type:  'POST', 
            cache: true, 
            dataType: "json",
            
            beforeSend: function () {
            $('#space_photo').html('<div id="preload_img" style="height: 75px" class="align-items-center justify-content-center text-center mt-4"><div class="spinner-border text-primary" role="status"></div></div>');
          },
            success:  function (data) { 

                const nombre = `${data.prinombre} ${data.priapellido}`;
                const iniciales = `${data.prinombre.charAt(0)}${data.priapellido.charAt(0)}`.toUpperCase();

                const color_tx = data.color_text;
                const color_bg = data.color_bg;
                let fotoHtml = `<img src="${data.foto}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 120px; height: 120px; object-fit: cover; border: 1px solid #aeafb0;">`;
                if (!data.foto) {
                  fotoHtml = `
                    <span class="rounded-circle d-flex align-items-center justify-content-center" style="
                      width: 120px; height: 120px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                      font-size: 60px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                        ${iniciales}
                    </span>`;
                  }

                $('#space_photo').html(fotoHtml);
                $('#prinombre').val(data.prinombre);
                $('#segnombre').val(data.segnombre);
                $('#priapellido').val(data.priapellido);
                $('#segapellido').val(data.segapellido);
                if(data.genero=='M'){ $("#genero_M").prop("checked", true);}
                if(data.genero=='F'){ $("#genero_F").prop("checked", true);}
                $('#sel_nacionalidad').val(data.id_nacionalidad);
                $('#f_nacimiento').val(data.f_nacimiento);
                $('#mail').val(data.email);
                $('#sel_tipodoc').val(data.id_tipo_doc_letra);
                $('#num_docip').val(data.num_doc);
            }
          });
    }
    function back()
    {   $('#div_tabla_listado').removeClass('visually-hidden');
        $('#div_tabla_detalle').addClass('visually-hidden');
    }
</script>
