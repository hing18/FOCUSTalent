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


        <!-- Google Fonts -->
       <!-- <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
         Vendor CSS Files -->

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

        <link href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- font-awesome 6.5.1 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
        <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css"rel="stylesheet">

       

    </head>
    <body>        
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
                <smal>@yield('content')</smal>
            </div>
        </main>

        @endauth
        
 
        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
        
        <script src="{{ asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
        <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.min.js')}}"></script>
       
        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
        <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>

        


      
        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js')}}"></script>
        <script> 
            $(document).ready(function() {
                $('#MyTable').DataTable({
                    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "columnDefs": [
                    {
                        "className": "align-middle", "targets": "_all"
                    }],
                });
                $('.MyTable').DataTable({
                    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "columnDefs": [
                    {
                        "className": "align-middle", "targets": "_all"
                    }],
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
        $image_crop = $('#image_demo_emplo').croppie({
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



                $('.crop_image_emplo').click(function(event){                    
                    $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                    }).then(function(response){

                    $.ajax({
                        url:"{{ route('empleados.subirfoto') }}",
                        type:'POST',
                        data:{"image":response,"cod":$('#lb_codigo').html(),"_token":$('input[name="_token"]').val()},
                        success:function(data){
                            $('#insertimageModal').modal('hide');
                   // load_images();
                   
                        //document.getElementById('img_photo').setAttribute("src", data);
                        
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
        </script>
    </body>
    

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css"  />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>


</html>
