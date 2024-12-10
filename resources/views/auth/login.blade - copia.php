<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
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

          <!-- Favicons -->
            <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
            <link href="{{ asset('assets/img/REGENCY_GROUP_Sf.png') }}" rel="apple-touch-icon">

            <!-- Google Fonts -->
            <link href="https://fonts.gstatic.com" rel="preconnect">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

            <!-- Vendor CSS Files -->
            <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>


            <!-- Template Main CSS File -->
            <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    </head>

    <body>



        <main>
            <div class="container">
        
              <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
        
                        <div class="d-flex justify-content-center">
                            <a href="index.html" class="d-flex align-items-center w-auto">
                            <img src="{{ asset('assets/img/REGENCY_GROUP_Sf.png')}}" alt="">
                            </a>
                        </div><!-- End Logo -->
        
                      <div class="card mb-3">
        
                        <div class="card-body">
        
                          <div class="pt-4 text-center">
                            <span class="align-items-center w-auto">
                                <img src="{{ asset('assets/img/Ft2.png')}}" alt="" width="90%">
                            </span>
                            <p class="text-center small"><b>Iniciar Sesión</b></p>
                          </div>
        
                          <form class="row g-3" action="{{route('/login')}}" method="post">
                            @csrf
                            <div class="col-12">
                              <label for="email" class="form-label">Correo</label>
                              <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-at text-secondary"></i></span>
                                <input type="email" id="email" name="email" class="form-control" required>
                              </div>
                            </div>
        
                            <div class="col-12">
                              <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group ">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
        
                            <div class="col-12">
                              <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                            </div>
                          </form>
        
                        </div>
                      </div>
        
                      <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ 
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
                      </div>
        
                    </div>
                  </div>
                </div>
        
              </section>
        
            </div>
          </main><!-- End #main -->
        
          <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        

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
