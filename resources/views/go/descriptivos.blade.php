<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Maestro de Descriptivos de Funciones')


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
    div#iframe {
      display: none;
    }
    div#preload {
      cursor: wait;
    }
  </style>
<!-- Button trigger modal -->
<div class="row">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="modalcrud(1,0)">
        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
          <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nuevo Descriptivo de Funciones</span>
        </a>
    </div>
  
</div>

<hr>

<small>
  <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
  </small>
<div id="iframe" style="display: none;">
  <div id="div_tabla">
      <table id="MyTable" class="display compact table table-striped shadow table-bordered bg-white table-sm" style="width:100%">
          <thead class="bg-secondary">
              <tr>
                  <th class="text-light text-center">NOMBRE DE DESCRIPTIVO</th>
                  <th class="text-light text-center">JERARQUÍA</th>
                  <th class="text-light text-center">TIPO</th>
                  <th class="text-light text-center">ESTATUS</th>
                  <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
              </tr>
          </thead>
          <tbody class="text-dark" id="bodyMyTable">
            @foreach( $data_df as $df )
              
              
              @php if($df->status=='true'){ $status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ $status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
              @endphp
              <tr>
                <td>{{$df->nombredesc}}</td>
                <td>{{$df->nombrejer}}</td>
                <td>{{$df->nombretipojer}}</td>
                <td><div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">@php echo $status; @endphp</div></div></td>
                <td>
                    <div class="row d-flex align-items-center justify-content-center text-center">
                      <div class="col-md-2 col-xs-6 text-secondary">
                        <i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,{{$df->id}})" data-bs-toggle="modal" data-bs-target="#Modal"></i>  
                      </div>
                      <div class="col-md-2 col-xs-6 text-secondary">
                        <i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,{{$df->id}})" ></i>
                      </div>
                    </div>
                </td>



            @endforeach

          </tbody>
      </table>
  </div>
</div>



  <!-- Modal -->
  <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h6 class="modal-title text-secondary fw-bold" id="ModalLabel">Modal title</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="frm_unidades">
            @csrf



            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Información General</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Responsabilidades</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Interacción / Seguridad</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="requisitos-tab" data-bs-toggle="tab" data-bs-target="#requisitos" type="button" role="tab" aria-controls="requisitos" aria-selected="false">Requisitos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="habilidades-tab" data-bs-toggle="tab" data-bs-target="#habilidades" type="button" role="tab" aria-controls="habilidades" aria-selected="false">Habilidades</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="autoridad-tab" data-bs-toggle="tab" data-bs-target="#autoridad" type="button" role="tab" aria-controls="autoridad" aria-selected="false">Autoridad del Puesto</button>
                </li>
              </ul>
            <div class="tab-content" id="myTabContent">

<!------- INFORMACIÓN GENERAL -->
                <div class=" tab-pane fade show active"  id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="my-3 fw-bold text-primary">I. INFORMACIÓN GENERAL</div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="namedf" class="col-form-label col-form-label-sm">Nombre de la posición:</label>
                                <input type="text" class="form-control form-control-sm" name="namedf" id="namedf">
                                <input type="hidden" id="iddf" value="0">
                            </div>
                            <div class="col-4">
                                <label for="idjer" class="col-form-label col-form-label-sm">Jerarquía:</label>
                                <select class="form-select form-select-sm" name="idjer" id="idjer" aria-label="Default select example">
                                    <option value='0' selected>Seleccione</option>
                                    @php
                                        $grupo='';$band=0;
                                    @endphp
                                    @foreach( $data_jer as $jer )
                                        @php
                                            if($grupo=='')
                                            {   echo'<optgroup label="'.$jer->tipo.'">';
                                                $grupo=$jer->tipo;
                                            }
                                            else {
                                            if($grupo!=$jer->tipo)
                                                {   echo'</optgroup><optgroup label="'.$jer->tipo.'">';
                                                $grupo=$jer->tipo;
                                                }
                                            }
                                        @endphp
                                    <option value="{{ $jer->id }}">{{ $jer->nombrejer }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="cargojefe" class="col-form-label col-form-label-sm">Cargo del jefe inmediato:</label>
                                <input type="text" class="form-control form-control-sm" name="cargojefe" id="cargojefe">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="nameareadf" class="col-form-label col-form-label-sm">Área o departamento al que pertenece:</label>
                                <input type="text" class="form-control form-control-sm" name="nameareadf" id="nameareadf">
                                
                            </div>
                            <div class="col-2">
                                <label for="numreportedir" class="col-form-label col-form-label-sm">Reportes directos: </label>
                                <input type="number" class="form-control form-control-sm" name="numreportedir" id="numreportedir" min="0">
                            </div>
                            <div class="col-4 pt-4 mt-2 text-center">
                                <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                                <label class="form-check-label" for="status">
                                    Habilitado
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="mt-3 text-primary"><b>II. PROPÓSITO GENERAL DEL CARGO</b></div> <div class="text-secondary mb-3"><small>Razón de ser, misión de la posición</small></div>              
                        <div class="mb-3">
                            <label for="txtproposito" class="form-label">Propósito del cargo:</label>
                            <textarea class="form-control" id="txtproposito" rows="3"></textarea>
                        </div>
                </div>

<!------- RESPONSABILIDADES -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mt-3 text-primary"><b>III. PRINCIPALES RESPONSABILIDADES DEL CARGO</b></div> <div class="text-secondary mb-3"><small>(Describa los resultados específicos que deben lograrse, debe de estar relacionado al Propósito General del Cargo: Verbo-Acción-Resultado)</small></div>
                </div>
<!------- INTERACCIÓN / SEGURIDAD -->
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="mt-3 text-primary"><b>IV. RELACIÓN DE INTERACCIÓN </b></div>
                <hr>
                    <div class="mt-3 text-primary"><b>V. SEGURIDAD DEL PUESTO </b></div>
                </div>
                    
<!------- REQUISITOS -->
                <div class="tab-pane fade" id="requisitos" role="tabpanel" aria-labelledby="requisitos-tab">
                    <div class="mt-3 text-primary"><b>VI. REQUISITOS DEL PUESTO </b></div>
                </div>
                     
<!------- HABILIDADES -->
                <div class="tab-pane fade" id="habilidades" role="tabpanel" aria-labelledby="habilidades-tab">
                    <div class="mt-3 text-primary"><b>VII. HABILIDADES Y OTROS CONOCIMIENTOS DEL PUESTO</b></div>
                </div>
                     
<!------- AUTORIDAD DEL PUESTO -->
                <div class="tab-pane fade" id="autoridad" role="tabpanel" aria-labelledby="autoridad-tab">
                    <div class="mt-3 text-primary"><b>VIII.  AUTORIDAD DEL PUESTO</b></div>
                </div>           
            </div>
          </form>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="su(1)"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
          <button type="button" class="btn btn-success btn-sm" onclick="su(2)"  tabindex="-1" id="bto_actualiza" style="display: none"><i class="fa-solid fa-arrows-rotate pr-2"></i> Actualizar</button>
        </div>
      </div>
    </div>
  </div>

@endsection

<script type='text/javascript'>

    function modalcrud(opt,id)
    {
      var _token = $('input[name="_token"]').val();
      document.getElementById('bto_guarda').style.display="none";
      document.getElementById('bto_actualiza').style.display="none";
      document.getElementById('iddf').value=0;

      //NUEVA
      if(opt==1)
      { document.getElementById('ModalLabel').innerHTML ='<i class="fas fa-plus pr-2 fa-lg"></i> Nuevo Descriptivo de Funciones';
        document.getElementById('bto_guarda').style.display="block";
        document.getElementById('namedf').value="";
        document.getElementById('idjer').value=0;
        document.getElementById('cargojefe').value="";
        document.getElementById('nameareadf').value="";
        document.getElementById('numreportedir').value=0;
        document.getElementById('txtproposito').value="";
        document.getElementById('status').checked=true;
      }
      //EDITA
      if(opt==2)
      { document.getElementById('ModalLabel').innerHTML ='<i class="fa-solid fa-pen-to-square  fa-lg"></i> Edita Descriptivo de Funciones';
        document.getElementById('bto_actualiza').style.display="block";
        document.getElementById('iddf').value=id;
        var parametros = {
        "id": id,
        "_token" : _token};
        $.ajax({
          data:  parametros,
          url:   "{{ route('descriptivos.edit') }}", 
          type:  'POST', 
          dataType: "json",
          cache: true, 
          success:  function (data) { 
            jQuery(data).each(function(i, item){ 
              document.getElementById('namedf').value=item.nombredesc; 
              document.getElementById('idjer').value=item.idjer; 
              document.getElementById('cargojefe').value=item.cargojefe; 
              document.getElementById('nameareadf').value=item.area_depto; 
              document.getElementById('numreportedir').value=item.reportes; 
              document.getElementById('txtproposito').value=item.proposito; 
              if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;}
            });
          }
        });
      }
      if(opt==3)
      { document.getElementById('iddf').value=id;
        document.getElementById('namedf').value='...'; 
        document.getElementById('idjer').selectedIndex=1;
        Swal.fire({
          title: "Eliminar descriptivo de funciones",
          text: "Al eliminar este descriptivo de funciones, se eliminará también su relación con las posiciones. Desea Continuar?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Eliminar!"
          }).then((result) => {
            if (result.isConfirmed) {su(opt);}
          });
      }
    }


function su(opt)
  { 
    var _token = $('input[name="_token"]').val();
    var namedf = $("#namedf" ).val();
    var cargojefe = $("#cargojefe" ).val();
    var nameareadf = $("#nameareadf" ).val();
    var numreportedir = $("#numreportedir" ).val();
    var txtproposito = $("#txtproposito" ).val();
    var idjer = $("#idjer" ).val();
    var status = document.getElementById('status').checked; 
    var id = $('#iddf').val();
    if(opt==1)
    { var urls="{{ route('descriptivos.store') }}";}
    if(opt==2)
    { var urls="{{ route('descriptivos.update') }}";}
    if(opt==3)
    { var urls="{{ route('descriptivos.destroy') }}";tipojer=1;idjer=1;}
    if(namedf.length>0)
    { if(idjer>0)
      { var parametros = {
        "namedf" : namedf,
        "idjer" : idjer,
        "cargojefe" : cargojefe,
        "nameareadf" : nameareadf,
        "numreportedir" : numreportedir,
        "txtproposito" : txtproposito,
        "status" : status,
        "id": id,
        "opt" : opt,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   urls,
          type:  'POST', 
          dataType: "json",
          cache: true, 
          success:  function (data) { 
            const table = new DataTable('#MyTable');
            table.clear().draw(); 
            jQuery(data).each(function(i, item){ 
              var status="";
              if(item.status=='true'){ status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
              table.row.add([
                item.nombredesc,
                item.nombrejer,
                item.nombretipojer,
                '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">'+status+'</div></div>',
                '<div class="row d-flex align-items-center justify-content-center text-center">'+
                '<div class="col-md-2 col-xs-6 text-secondary">'+
                '<i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,'+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
                '</div>'+
                '<div class="col-md-2 col-xs-6 text-secondary">'+
                '<i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,'+item.id+')" ></i>'+
                '</div>'+
                '</div>'
              ]).draw(false);
            });
            document.getElementById('namedf').value="";
            document.getElementById('idjer').value=0;
            document.getElementById('cargojefe').value="";
            document.getElementById('nameareadf').value="";
            document.getElementById('numreportedir').value=0;
            document.getElementById('txtproposito').value="";
            document.getElementById('status').checked=true;
            if(opt==1)
            { bien('El descriptivo de funciones ha sido creado');}
            if(opt==2)
            { bien('El descriptivo de funciones ha sido actualizado');}
            if(opt==3)
            { bien('El descriptivo de funciones ha sido eliminado');}
            $('#Modal').modal('hide');
          }
        });
      }
      else
      { mal('Por favor seleccionar la Jerarquía');}
    }
    else
    { mal('Por favor colocar el nombre de la posición del descriptivo de funciones');}
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