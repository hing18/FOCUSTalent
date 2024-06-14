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

        <!-- Favicons -->
        <link href="assets/img/favicon.png') }}" rel="icon">
        <link href="assets/img/REGENCY_GROUP_Sf.png" rel="apple-touch-icon">
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
        <style>
            table.dataTable td {  font-size: 0.75em;}
            table.dataTable th {  font-size: 0.75em;}

            .editlink{                
                color:#007BFF;
            }
            .editlink:hover{
                
                color:#6C757D;
                cursor: pointer
            }

            .msnwarning
            {
                color:#ffcc00 
            }
            .msnwarning:hover{
                
                color:#007BFF;
                cursor: pointer;
            }
            .msnwarningactivo
            {
                color:#20881a 
            }
            .msnwarningactivo:hover{
                
                color:#007BFF;
                cursor: pointer;
            }

            .edit{                
                color:#6C757D;
            }
            .edit:hover{
                
                color:#007BFF;
                cursor: pointer;
            }
            .dell{
                
                color:#6C757D;
            }
            .dell:hover{
                
                color:#DC3545;
                cursor: pointer;
            }
            
            .activar{
                
                color: #13890d;
            }
            .activar:hover{
                
                color: #0d6efd;
                cursor: pointer;
            }
            
            .activar_part{
                
                color: #13890d;
            }
            .activar_part:hover{
                
                color: #0d6efd;
                cursor: pointer;
            }
        </style>
        @auth
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="row">
                <div class="col">
                    <span class="align-items-center">
                        <img src="{{ asset('assets/img/HeadControl.png')}}" alt="" width="100%">
                    </span>
                </div>
                <div class="col">
                        <i class="bi bi-list toggle-sidebar-btn"></i>
                </div>
            </div><!-- End Logo -->
            
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <img src="{{ asset('assets/img/profile-img.png') }}" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
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

        <main id="main" class="main">
            <section class="section dashboard">
                <div class="row">

                    <div class="pagetitle">
                    <h5 class="text-primary fw-bold">@yield('title')</h5>
                    </div> 
                    
                    <div class="row-12" >
                        <smal>@yield('content')</smal>
                    </div>
                </div>
            </section>
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
            });
        </script>
    </body>
</html>