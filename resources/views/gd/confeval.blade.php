<!DOCTYPE html>
@extends('layouts.plantilla')
@section('title','Administración de Evaluaciones')
@section('content')
<!-- JavaScript -->
<script type="text/javascript">
    function preloader(){
        document.getElementById("preload").style.display = "none";
        document.getElementById("iframe").style.display = "block";
    }
     window.onload = preloader;
</script>

<div class="card mb-3">
    <div class="card-header pb-0">
      <h4><i class="fas fa-cogs fa-lg"></i> Configuración de Evaluación del Desempeño</h4>
    </div>
    <div class="card-body">
      <small>
        <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
      </small>
          <div id="iframe" style="display: none;">
            @csrf
            <!-- LISTADO DE EVALUACIONES-->
            <div id="lista_eval" class="mt-4">
              <div class="row mb-2 ms-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="modalcrud()">
                  <div class="col text-start h5 text-info "> <i class="fas fa-th-list pe-2"></i> Listado de Evaluaciones</div>
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
                      <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Evaluación</span>
                    </a>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <table  id="MyTable_eval" class="table small table-sm table-striped table-hover" style="width:100%">
                    <thead class="bg-info">
                      <tr>
                        <th class="text-light text-center bg-info" width="25%" >NOMBRE</th>
                        <th class="text-light text-center bg-info" width="15%" >ESTATUS</th>
                        <th class="text-light text-center bg-info" width="15%" >DESDE</th>
                        <th class="text-light text-center bg-info" width="15%" >HASTA</th>
                        <th class="text-light text-center bg-info" width="15%" >POBLACIÓN</th>
                        <th class="text-light text-center bg-info" width="15%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_eval">
                      @foreach( $evaluaciones as $pos )
                        @php if($pos->status==1){ $status='<span class="border border-success rounded text-success py-1 ps-2 pe-2 fw-bold"><i class="fas fa-check-circle fa-lg pe-2"></i>Activa </span>';}
                        @endphp
                        <tr>
                          <td style="text-align: center; vertical-align: middle;" id="eval_sel_{{ $pos->id }}">{{ $pos->observacion }}</td>
                          <td style="text-align: center; vertical-align: middle;">@php echo $status; @endphp</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->desde }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->hasta }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->total }}</td>
                          <td style="text-align: center; vertical-align: middle;">
                            <div class="dropdown py-0">
                              <button class="btn btn-sm dropdown-toggle btn-outline-info" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>
                              <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="mod_prospectos('+id_ofl_txt+')" data-bs-toggle="modal" data-bs-target="#modalprooectos"><i class="fas fa-cogs pe-1"></i> Configuración</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="mod_prospectos('+id_ofl_txt+')" data-bs-toggle="modal" data-bs-target="#modalprooectos"><i class="fas fa-tachometer-alt pe-1"></i> Avances</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="levaldores({{ $pos->id }})" ><i class="fas fa-user-tie pe-1"></i> Evaluadores</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="levaldos({{ $pos->id }})"><i class="fas fa-user-check pe-1"></i> Evaluados</button></li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- LISTADO DE EVALUADOS -->
            <div id="div_evaluados" class="visually-hidden mt-4">
              <div class="row mb-2 ms-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                  <div class="col text-start h5 text-primary"><i class="fas fa-users pe-2"></i> Listado de Evaluados - <span class="text-secondary" id="nom_eval_evaldo"></span></div>
                    <a href="#" class="btn btn-sm btn-secondary" onclick="back()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <table  id="MyTable" class="display compact table table-sm table-striped table-hover" style="width:100%">
                    <thead class="bg-primary">
                      <tr>
                        <th class="text-light text-center bg-primary" width="25%" >EVALUADO</th>
                        <th class="text-light text-center bg-primary" width="25%" >PUESTO</th>
                        <th class="text-light text-center bg-primary" width="25%" >EVALUADOR</th>
                        <th class="text-light text-center bg-primary" width="10%" >RESULTADO</th>
                        <th class="text-light text-center bg-primary" width="5%" >ESTADO</th>
                        <th class="text-light text-center bg-primary" width="10%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_evaluados">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


            <!-- LISTADO DE EVALUADORES -->
            <div id="div_evaluadores" class="visually-hidden mt-4">
              <div class="row mb-2 ms-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                  <div class="col text-start h5 text-primary"><i class="fa-solid fa-user-tie pe-2"></i> Listado de Evaluadores - <span class="text-secondary" id="nom_eval_evaldores"></span></div>
                    <a href="#" class="btn btn-sm btn-secondary" onclick="back()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <table  id="MyTable2" class="display MyTable compact table table-sm table-striped table-hover" style="width:100%">
                    <thead>
                      <tr>
                        <th class="text-light text-center bg-primary" width="25%" >EVALUADOR</th>
                        <th class="text-light text-center bg-primary" width="25%" >PUESTO</th>
                        <th class="text-light text-center bg-primary" width="40%" >UNIDAD</th>
                        <th class="text-light text-center bg-primary" width="10%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_evaluadores">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2 bg-light">
        <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fas fa-sync fa-lg pe-2"></i>  <span class="text-primary">Cambiar Estado</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body small">
        <span id="lb_nombre_estatus"></span>
        <input type="hidden" value="0" id="fil">
        <input type="hidden" value="0" id="ideval">
        <div class="form-group row text-center mt-4">
          <label for="sel_estatus" class="col-sm-2 col-form-label">Estado: </label>
          <div class="col-sm-8">
            <select class="form-select form-select-sm" id="sel_estatus">
              <option value="1">Pendiente</option>
              <option value="2">En proceso</option>
              <option value="3">Evaluado</option>
              <option value="4">Rechazado</option>
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer py-2 bg-light">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="cambiast()"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal CAMBIA PASS-->
<div class="modal fade" id="cambia-pass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2 bg-light">
        <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fas fa-sync fa-lg pe-2"></i> <span class="text-primary">Cambiar contraseña de evaluador</span> </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body small">
        <form>
        <input type="hidden" value="0" id="filr">
        <input type="hidden" value="0" id="idevalr">
        
          <div class="form-group py-2">
            @csrf
              <label id="lb_nombre_estatusr" class="form-label pb-2"></label>
              <br>
              <label id="passEmail" class="form-label pb-2 ">Correo</label>
              <br>
              <label for="password" class="form-label">Nueva contraseña</label>
              <div class="input-group  pb-2">
                <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                <input type="text" id="password" name="password" class="form-control">
              </div>

              <div class="form-check py-2">
                <input type="checkbox" class="form-check-input" id="resetpass" name="resetpass">
                <label class="form-check-label" for="resetpass">Restablecer cuando ingresa</label>
              </div>
          </div>     
        </form>
      </div>

      <div class="modal-footer py-2 bg-light">
        <span id="lb_msn" class="text-danger small visually-hidden"><i class="fas fa-unlock-alt"></i> Colocar la nueva contraseña.</span>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="restpass()"  tabindex="-1" id="bto_guarda" style="display: block"><i id="ico_refresh" class="fas fa-sync"></i> Cambiar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal  CAMBIA EVALUADOR-->
<div class="modal fade" id="cambiaevaldor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header py-2 bg-light">
        <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fas fa-people-arrows fa-lg pe-2"></i>  <span class="text-primary">Cambiar Evaluador</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body small">
        <span id="lb_nombre_evaluado"></span>
        <input type="hidden" value="0" id="fil_evaldor">
        <input type="hidden" value="0" id="ideval_evaldor">
        <div class="row">
          <div class="col">            
            <!-- Table with stripped rows -->
            <table id="table_evaluadores" class="table MyTable table-sm table-striped table-hover" style="width:100%">
              <thead>
                <tr>
                  <th class="text-light text-center bg-secondary" width="4%">SEL.</th>
                  <th class="text-light text-center bg-secondary" width="10%">CÓDIGO</th>
                  <th class="text-light text-center bg-secondary" width="36%">NOMBRE</th>
                  <th class="text-light text-center bg-secondary" width="50%">PUESTO</th>
                </tr>
              </thead>
              <tbody id="tbody_evaluadores">
                
                
              </tbody>
            </table>
          
            <!-- End Table with stripped rows -->

          </div>
        </div>
      </div>

      <div class="modal-footer py-2 bg-light">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="guardaevaldor()"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal CAMBIA PUESTO-->
<div class="modal fade" id="cambiarpuesto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2 bg-light">
        <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fa-solid fa-person-circle-check fa-lg pe-2"></i>  <span class="text-primary">Cambiar Puesto a Evaluar</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body small">
        <span id="lb_nombre_puesto"></span>
        <input type="hidden" value="0" id="fil_puesto">
        <input type="hidden" value="0" id="ideval_puesto">
        <div class="form-group row text-center mt-4">
          <label for="sel_unidad" class="col-sm-auto col-form-label">Unidad: </label>
          <div class="col-sm-8">
            <select class="form-select form-select-sm" id="sel_unidad">
>
            </select>
          </div>
        </div>
        <div class="form-group row text-center mt-4">
          <label for="sel_puesto" class="col-sm-auto col-form-label">Puesto Evaluado: </label>
          <div class="col-sm">
            <select class="form-select form-select-sm" id="sel_puesto">
>
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer py-2 bg-light">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="cambiapuesto()"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

@endsection

<script>
  function levaldos(cod)
  { $('#div_evaluados').removeClass('visually-hidden');
    $('#nom_eval_evaldo').html($('#eval_sel_'+cod).html());
    $('#lista_eval').addClass('visually-hidden');
      var parametros = {
        "id_eval":cod,
        "_token": $('input[name="_token"]').val()};
        $.ajax({
          data:  parametros,
          url:   "{{ route('evaluacion.levaldos') }}",
          type:  'POST',
          cache: false,
          dataType: "json",
          beforeSend: function () {
            $('#tbody_list_evaluados').html('<tr><td colspan="6"><div class="text-center  text-primary"><div class="spinner-border spinner-border-sm" role="status"></div><span class="ps-2">Cargando...</span></div></td></tr>');
          },
          success:  function (data) {
              const table = new DataTable('#MyTable');
              table.clear().draw();
              x=0;
              jQuery(data.evaluados).each(function(i, item){
                var status=""; var resultado="";var estado_eval="";
                x++;
                if(item.status==1){
                  status='<span class="badge bg-secondary">Pendiente</span>';
                  estado_eval='';
                }
                if(item.status==2){ status='<span class="badge bg-warning">En Proceso</span>';}
                if(item.status==3){ status='<span class="badge bg-primary">Evaluado</span>';
                  resultado=Number(item.resultado).toFixed(1)+ "%";}
                if(item.status==4){ status='<span class="badge bg-danger">Rechazado</span>';}
                var nombre=item.prinombre + " " + item.priapellido;
                var evaldor=item.nom_evaldor + " " + item.ape_evaldor;

                table.row.add([
                  '<span id="code_evaldo_'+x+'">'+item.id_evaluado+ '</span> - <span id="nom_evaldo_'+x+'">'+nombre+ "</span>",
                  item.descpue,
                  '<span id="code_evaldor_'+x+'">'+item.id_evaluador+ "</span> - " + '<span id="nom_evaldor_'+x+'">'+evaldor+ "</span>",
                  '<div  class="fw-bold text-center" style="text-align: center; vertical-align: middle;"  id="res_'+x+'">'+resultado+'</div>',
                  '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col" id="st_'+x+'">'+status+'</div></div>',
                  '<div class="dropdown py-0">'+
                    '<button class="btn btn-sm btn-sm dropdown-toggle btn-outline-primary" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>'+
                      '<ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">'+
                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#cambiarpuesto" type="button" onclick="cambiapuesto('+cod+','+x+')"><i class="fa-solid fa-person-circle-check pe-1"></i> Cambiar Puesto</button></li>'+
                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" onclick="cambiaestado('+cod+','+item.status+','+x+')"><i class="fas fa-sync pe-1"></i> Cambiar Estado</button></li>'+
                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#cambiaevaldor" type="button" onclick="cambiaevaldor('+cod+','+x+')"><i class="fas fa-people-arrows pe-1"></i> Cambiar Evaluador</button></li>'+
                      '</ul>'+
                  '</div>'
                ]).draw(false);
              });
          }
        });
  }
  
  function levaldores(cod)
  { $('#div_evaluadores').removeClass('visually-hidden');
    $('#nom_eval_evaldores').html($('#eval_sel_'+cod).html());
    $('#lista_eval').addClass('visually-hidden');
      var parametros = {
        "id_eval":cod,
        "_token": $('input[name="_token"]').val()};
        $.ajax({
          data:  parametros,
          url:   "{{ route('evaluacion.levaldores') }}",
          type:  'POST',
          cache: false,
          dataType: "json",
          beforeSend: function () {
            $('#tbody_list_evaluadores').html('<tr><td colspan="4"><div class="text-center  text-primary"><div class="spinner-border spinner-border-sm" role="status"></div><span class="ps-2">Cargando...</span></div></td></tr>');
          },
          success:  function (data) {
              const table = new DataTable('#MyTable2');
              table.clear().draw();
              x=0;
              jQuery(data.evaluadores).each(function(i, item){

                x++;

                var nombre=item.prinombre + " " + item.priapellido;  

                table.row.add([
                  '<span id="code_evaldor_'+x+'">'+item.id_evaluador+ '</span> - <span id="nom_evaldor_'+x+'">'+nombre+ "</span>",
                  item.descpue,
                  '<div id="res_'+x+'">'+item.nameund+'</div>',
                  '<div class="dropdown py-0">'+
                    '<button class="btn btn-sm btn-sm dropdown-toggle btn-outline-primary" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>'+
                      '<ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">'+

                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#cambia-pass" type="button" onclick="cambiapass('+cod+','+x+')"><i class="fas fa-sync pe-1"></i> Cambiar Contraseña</button></li>'+
                      '</ul>'+
                  '</div>'
                ]).draw(false);
              });
          }
        });
  }

  function cambiaestado(eval,st,x)
  {
    $('#lb_nombre_estatus').html($('#code_evaldo_'+x).html()+ ' - '+$('#nom_evaldo_'+x).html());
    $('#fil').val(x);
    $('#ideval').val(eval);
    $('#sel_estatus').val(st);
  }

  function cambiapuesto(eval,x)
  { $('#lb_nombre_puesto').html($('#code_evaldo_'+x).html()+ ' - '+$('#nom_evaldo_'+x).html());
    $('#fil_puesto').val(x);
    $('#ideval_puesto').val(eval);
    
    var parametros = {
    "eval_id": eval,
    "evaldo_id": $('#code_evaldo_'+x).html(),
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.cambiapuesto') }}",
      type:  'POST', 
      cache: true, 
      dataType: "json",
      success:  function (data) {
        const table = new DataTable('#table_evaluadores');
        table.clear().draw();
        i=0;
        jQuery(data).each(function(i, item){ 
          i++;
          var nombre=item.prinombre + " " + item.priapellido;
          var sel="";
          if(item.id_evaluador==$('#code_evaldor_'+x).html())
          { sel="checked";}
           table.row.add([
            '<div style="text-align: center; vertical-align: middle;"><input class="form-check-input" style="width: 15px; height: 15px; cursor: pointer;" value="'+item.id_evaluador+'" type="radio" name="chk[]" id="chk_'+i+'" '+sel+'></div>',
            '<div style="text-align: center; vertical-align: middle;">'+item.id_evaluador+'</div>',
            nombre,
            item.descpue,
          ]).draw(false);
        });
      }
    });

  }

  function cambiapass(eval,x)
  { $('#passEmail').html('');
    $("#resetpass").prop("checked", true);
    $('#lb_nombre_estatusr').html("Evaluador: "+$('#code_evaldor_'+x).html()+ ' - '+$('#nom_evaldor_'+x).html());
    $('#filr').val(x);
    $('#idevalr').val(eval);
    var parametros = {
    "id_evaldor": $('#code_evaldor_'+x).html(),
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.mailevaluador') }}",
      type:  'POST',
          cache: true,
          dataType: "json",
      
      success:  function (data) {
        jQuery(data).each(function(i, item){ 
        $('#passEmail').html("Correo: <span id='mail'>"+item.mail+"</span>");
      });
      }
    });
  }

  function restpass()
  { $('#lb_msn').addClass('visually-hidden');
    chk=0;
    if ($("input[name='resetpass']").is(':checked')) 
    { chk=1;}
    pass=$('#password').val();
    if(pass.length < 3) {
      $('#lb_msn').removeClass('visually-hidden');
      setTimeout(function(){ $('#lb_msn').addClass('visually-hidden')}, 2000);
      $('#password').focus();
    }
    else{
      var parametros = {
    "id_evaldor" : $('#code_evaldor_'+$('#filr').val()).html(),
    "mail" : $('#mail').html(),
    "newpass":pass,
    "chk": chk,
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.resetpass') }}",
      type:  'POST',
      beforeSend: function () { $('#ico_refresh').addClass('fa-pulse'); },
      cache: true,      
      success:  function (data) {
        if(data==0)
        { mal("Contraseña no restablecida, por favor validar los datos del usuario");}
        else
        { bien("Contraseña restablecida.");}
        $('#ico_refresh').removeClass('fa-pulse');
        $('#cambia-pass').modal('hide');
      }
    });
    }
  }


  function cambiaevaldor(eval,x)
  { $('#lb_nombre_evaluado').html($('#code_evaldo_'+x).html()+ ' - '+$('#nom_evaldo_'+x).html());
    $('#fil_evaldor').val(x);
    $('#ideval_evaldor').val(eval);
    var parametros = {
    "eval_id": eval,
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.evaluadores') }}",
      type:  'POST', 
      cache: true, 
      dataType: "json",
      success:  function (data) {
        const table = new DataTable('#table_evaluadores');
        table.clear().draw();
        i=0;
        jQuery(data).each(function(i, item){ 
          i++;
          var nombre=item.prinombre + " " + item.priapellido;
          var sel="";
          if(item.id_evaluador==$('#code_evaldor_'+x).html())
          { sel="checked";}
           table.row.add([
            '<div style="text-align: center; vertical-align: middle;"><input class="form-check-input" style="width: 15px; height: 15px; cursor: pointer;" value="'+item.id_evaluador+'" type="radio" name="chk[]" id="chk_'+i+'" '+sel+'></div>',
            '<div style="text-align: center; vertical-align: middle;">'+item.id_evaluador+'</div>',
            nombre,
            item.descpue,
          ]).draw(false);
        });
      }
    });
  }

  function guardaevaldor()
  { band=0;
    $('[name="chk[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          new_cod_evaluador=$(this).val();
          band=1;
        }
    });

    if(band==1)
    {
      Swal.fire({
        text: 'Se cambiará el evaluador para el colaborador. ¿Desea continuar?',

        showCancelButton: true,
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, continuar',
        confirmButtonColor: "#d33",
        icon: "warning",
      }).then((result) => {

        if (result.isConfirmed)
        { 
            
          var parametros = {
          "cod_evaluado": $('#code_evaldo_'+$('#fil_evaldor').val()).html(),
          "cod_evaluador": $('#code_evaldor_'+$('#fil_evaldor').val()).html(),
          "new_cod_evaluador": new_cod_evaluador,
          "eval_id": $('#ideval_evaldor').val(),
          "_token" : $('input[name="_token"]').val()}
          $.ajax({
            data:  parametros,
            url:   "{{ route('evaluacion.updateevaldor') }}",
            type:  'POST', 
            cache: true, 
            dataType: "json",
            success:  function (data) {
              
              jQuery(data).each(function(i, item){ 
                var nombre=item.prinombre + " " + item.priapellido;
                $('#code_evaldor_'+$('#fil_evaldor').val()).html(item.id);
                $('#nom_evaldor_'+$('#fil_evaldor').val()).html(nombre);
                bien("El evaluador ha sido actualizado.");
                $('#cambiaevaldor').modal('hide');
              });
            }
          });
        }
      });
    }else{
      mal('Debe seleccionar un evaluador.');
    }



    
  }

  function back()
  { $('#div_evaluados').addClass('visually-hidden');
    $('#div_evaluadores').addClass('visually-hidden');
    $('#lista_eval').removeClass('visually-hidden');
  }

  function cambiast()
  {
    var st = $('#sel_estatus').val();

    var msn="";
      if(st==1) { msn="Se reiniciará la evaluación del colaborador. ¿Desea continuar?";}
      if(st==2) { msn="Se abrirá la evaluación del colaborador permitiendo al evaluador editar la misma. ¿Desea continuar?";}
      if(st==3) { msn="Finalizará la evaluación del colaborador. ¿Desea continuar?";}
      if(st==4) { msn="El colaborador no será evaluado. ¿Desea continuar?";}

      Swal.fire({
        text: msn,

        showCancelButton: true,
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, continuar',
        confirmButtonColor: "#d33",
        icon: "warning",
      }).then((result) => {

        if (result.isConfirmed)
        {   var parametros = {
            "cod_evaluado": $('#code_evaldo_'+$('#fil').val()).html(),
            "cod_evaluador": $('#code_evaldor_'+$('#fil').val()).html(),
            "eval_id": $('#ideval').val(),
            "st": $('#sel_estatus').val(),
            "_token" : $('input[name="_token"]').val()}
            $.ajax({
              data:  parametros,
              url:   "{{ route('evaluacion.editstatus') }}",
              type:  'POST',
              cache: true,
              success:  function (data) {
                if(st==1){ $('#res_'+$('#fil').val()).html('');}
                $('#st_'+$('#fil').val()).html(data);
                bien("El estado ha sido actualizado.");
                $('#staticBackdrop').modal('hide');
              }
            });
          }
        });
  }

  function mal(msn)
  {
      Swal.fire({
        position: 'center',
        icon: 'warning',
        text: msn,
      })
  }
    
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

</script>
