<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <link href="{{ asset('assets/img/favicon.png')}}" rel="icon">


        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

        <link href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- font-awesome 6.5.1 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
        <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css"rel="stylesheet">







<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    </head>
    
    <body>        
        <link href="https://cdn.jsdelivr.net/npm/trix@1.3.1/dist/trix.css" rel="stylesheet">
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        @auth
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="row text-start">
                <div class="col-4 d-flex align-items-center">
                        <img src="{{ asset('assets/img/Ft2.png')}}" alt="" width="100%">
                   
                </div>
                <div class="col ms-0">
                        <i class="bi bi-list toggle-sidebar-btn text-light"></i>
                </div>
            </div><!-- End Logo -->
            
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                           {{ photo_user(Auth::user()->id) }}
                         
                            
                            

                            <span class="d-none d-md-block dropdown-toggle ps-2 text-light">{{ Auth::user()->name }}</span>
                        </a><!-- End Profile Iamge Icon -->
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span>{{ Auth::user()->codigo }}</span>
                            </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Salir</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul><!-- End Profile Nav -->
            </nav><!-- End Icons Navigation -->
        </header><!-- End Header -->
   
        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                {{  menu_id($id_menu,$id_menu_sup,Auth::user()->id) }}
            </ul>

        </aside><!-- End Sidebar-->

        <main id="main" class="main pt-0">         
            <div class="row-12 pt-0" >
                @yield('content')
            </div>
        </main>


        
        <!-- Modal de advertencia por inactividad -->
        <div class="modal fade" id="sessionWarningModal" tabindex="-1" aria-labelledby="sessionWarningModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                <h5 class="modal-title" id="sessionWarningModalLabel">Tu sesión está a punto de finalizar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Estás por ser redirigido al inicio de sesión debido a la inactividad. Si deseas continuar, haz clic en el botón para permanecer en la página.
                </div>
                <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Permanecer conectado</button>
                <button type="button" class="btn btn-primary" onclick="redirectToLogin()">Redirigir al Login</button>
                </div>
            </div>
            </div>
        </div>
<!--
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>-->

        @endauth        
 
        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
        
        <script src="{{ asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
        <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.min.js')}}"></script>
       
        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
      <!--  
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
     
      
        <!-- Template Main JS File -->
        
        <script src="{{ asset('assets/js/main.js')}}"></script>
        <script> 

            $(document).ready(function () {
                $('#MyTable').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "columnDefs": [
                        { "className": "align-middle", "targets": "_all" }
                    ],
                    "paging": true,       // asegúrate de que esté activado
                    "searching": true,    // habilita búsqueda
                    "info": true,         // muestra info tipo "Mostrando X de Y"
                    "lengthChange": true, // permite cambiar cantidad de registros por página
                    "order": [], // desactiva ordenamiento por defecto
                });

                $image_crop = $('#image_demo').croppie({
                    enableExif: true,
                    viewport: {
                    width:200,
                    height:200,
                    type:'square' //circle
                    },
                    boundary:{
                    width:300,
                    height:300
                    }    
                });

                $('#insert_image').on('change', function(){
                       var reader = new FileReader();
                        reader.onload = function (event) {
                            $image_crop.croppie('bind', {
                                url: event.target.result
                            }).then(function(){
                                console.log('jQuery bind complete');
                            });
                        }
                        reader.readAsDataURL(this.files[0]);
                        $('#insertimageModal').modal('show');
                    
                });          



                $('.crop_image').click(function(event){
                    
                    $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                    }).then(function(response){

                    $.ajax({
                        url:"{{ route('ofertas.subirfoto') }}",
                        type:'POST',
                        data:{"image":response,"num_aprob_ofl":$('#id_curri').val(),"_token":$('input[name="_token"]').val()},
                        success:function(data){
                            $('#insertimageModal').modal('hide');
                   // load_images();
                   
                        //document.getElementById('img_photo').setAttribute("src", data);
                        
                        $('#insert_image').val('');
                        $('#space_photo').html(data);                       
                        
                        }
                    })
                    });
                });

                $('.corp_back').click(function(event){
                    $('#insert_image').val('');
                });
            });

            $(document).ready(function() {
                $image_crop_emplo_me = $('#image_demo_emplo').croppie({
                    enableExif: true,
                    viewport: {
                    width:200,
                    height:200,
                    type:'square' //circle
                    },
                    boundary:{
                    width:300,
                    height:300
                    }    
                });

                $('#insert_image_emplo').on('change', function(){
                       var reader_me = new FileReader();
                        reader_me.onload = function (event) {
                            $image_crop_emplo_me.croppie('bind', {
                                url: event.target.result
                            }).then(function(){
                                console.log('jQuery bind complete');
                            });
                        }
                        reader_me.readAsDataURL(this.files[0]);
                        $('#insertimageModal').modal('show');
                    
                });          

                $('.crop_image_emplo').click(function(event){                    
                    $image_crop_emplo_me.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                    }).then(function(response){
                    $.ajax({
                        url:"{{ route('empleados.subirfoto') }}",
                        type:'POST',
                        data:{"image":response,"cod":$('#lb_codigo').html(),"_token":$('input[name="_token"]').val()},
                        success:function(data){
                            $('#insertimageModal').modal('hide');
                            $('#insert_image_emplo').val('');
                            $('#space_photo').html(data);
                        }
                    })
                    });
                });



                $('.corp_back').click(function(event){
                    $('#insert_image_emplo').val('');
                });

            });


            $(document).ready(function() {
                $image_crop_emplo = $('#image_bd').croppie({
                    enableExif: true,
                    viewport: {
                    width:200,
                    height:200,
                    type:'square' //circle
                    },
                    boundary:{
                    width:300,
                    height:300
                    }    
                });

                $('#insert_image_bd').on('change', function(){
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $image_crop_emplo.croppie('bind', {
                            url: event.target.result
                        }).then(function(){
                            console.log('jQuery bind complete');
                        });
                    }
                    reader.readAsDataURL(this.files[0]);
                    $('#insertimageModal').modal('show');
                });          

                $('.crop_image_bd').click(function(event){                    
                    $image_crop_emplo.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                    }).then(function(response){
                        $.ajax({
                            url:"{{ route('bd.subirfoto') }}",
                            type:'POST',
                            data:{"image":response,
                            "_token":$('input[name="_token"]').val()},
                           success: function(data){
                                $('#insertimageModal').modal('hide');
                                $('#insert_image_bd').val('');
                                $('#space_photo').html(data.html);
                                // Guardar ruta temporal para el formulario                                
                                $('#foto_temp_path').val(data.temp_path);                                
                            }
                        })
                    });
                });
                $('.corp_back').click(function(event){
                    $('#insert_image_bd').val('');
                });
            });
document.addEventListener('DOMContentLoaded', function () {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl)
  })
})
        </script>

    <!-- SCRIPT DE REDIRECCIONAMIENTO POR TIMEPO DE INACTIVIDAD -->

    <script>
        // Definir la duración de la sesión en milisegundos
        var sessionTimeout = @json(config('session.lifetime') * 60 * 1000); // 1 minuto (1000 ms * 60 * 1)
    
        // Definir el tiempo antes de que aparezca el modal (30 segundos)
        var warningTime = 30 * 1000; // 30 segundos
    
        var timer;
    
        // Función para mostrar el modal de advertencia
        function showWarningModal() {
            // Mostrar modal con un mensaje
            $('#sessionWarningModal').modal('show');
        }
    
        // Función para redirigir al usuario a la página de login
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";  // Redirigir al login
        }
    
        // Temporizador para comprobar la inactividad
        function startInactivityTimer() {
            timer = setTimeout(function () {
                showWarningModal();
    
                // Configurar la redirección después de 30 segundos
                setTimeout(function () {
                    redirectToLogin();
                }, warningTime);
            }, sessionTimeout - warningTime);
        }
    
        // Reiniciar el temporizador de inactividad cada vez que el usuario haga una acción
        $(document).on('mousemove keydown click scroll', function() {
            clearTimeout(timer);
            startInactivityTimer();
        });
    
        // Iniciar el temporizador cuando la página carga
        $(document).ready(function () {
            startInactivityTimer();
        });


          $(document).ready(function() {
            $('#sw_verperfil').on('change', function() {
            if ($(this).is(':checked')) {
                // Mostrar perfil
                $('#div_form_perfil').removeClass('d-none');
                $('#div_form_solicitud').addClass('d-none');

                // Ocultar botones
                $('#bto_cancelar, #bto_guarda').addClass('d-none');
                $('#div_modalsoli').addClass('modal-xl');
                $('#div_modalsoli').removeClass('modal-lg');
                $('#lb_verperfil').addClass('text-primary');
            } else {
                // Mostrar solicitud
                $('#div_form_solicitud').removeClass('d-none');
                $('#div_form_perfil').addClass('d-none');

                // Mostrar botones
                $('#bto_cancelar, #bto_guarda').removeClass('d-none');
                $('#div_modalsoli').addClass('modal-lg');
                $('#div_modalsoli').removeClass('modal-xl');
                $('#lb_verperfil').removeClass('text-primary');
            }
            });
        });
        
        document.getElementById('filtroBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('filtroDropdown').classList.toggle('show');
        });

        window.addEventListener('click', function() {
            document.getElementById('filtroDropdown').classList.remove('show');
        });

    </script>

<script src="https://cdn.jsdelivr.net/npm/trix@1.3.1/dist/trix.js"></script>







</body>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css"  />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>

</html>
