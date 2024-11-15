<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <style>
    
      /*--------------------------------------------------------------
      # Hero Section
      --------------------------------------------------------------*/





      #cta .animated {
        animation: up-down 2s ease-in-out infinite alternate-reverse both;
      }

      @media (max-width: 991px) {
        #cta {
          height: 100vh;
          text-align: center;
        }
        #cta .animated {
          -webkit-animation: none;
          animation: none;
        }
        #cta .hero-img {
          text-align: center;
        }
        #cta .hero-img img {
          width: 50%;
        }
      }

      @media (max-width: 768px) {
        #cta h1 {
          font-size: 28px;
          line-height: 36px;
        }
        #cta h2 {
          font-size: 18px;
          line-height: 24px;
          margin-bottom: 30px;
        }
        #cta .hero-img img {
          width: 70%;
        }
      }

      @media (max-width: 575px) {
        #cta .cta-img img {
          width: 80%;
        }
        #cta .btn-get-started {
          font-size: 16px;
          padding: 10px 24px 11px 24px;
        }
      }

      @-webkit-keyframes up-down {
        0% {
          transform: translateY(10px);
        }
        100% {
          transform: translateY(-10px);
        }
      }

      @keyframes up-down {
        0% {
          transform: translateY(10px);
        }
        100% {
          transform: translateY(-10px);
        }
      }

      .cta {
  background: linear-gradient(rgba(40, 58, 90, 0.9), rgba(40, 58, 90, 0.9)), url("assets/img/tdla.jpg") fixed center center;
  background-size: cover;
  
}
#cta .container {
        padding-top: 8%;
      }
    
    </style>

    <section id="cta" class="cta d-flex align-items-center pb-4 mb-4">
      <div class="container mb-4">
        <div class="row">
          <div class="col-lg-7 d-flex flex-column justify-content-center text-center">          
            <span class="cta-img mb-4" data-aos="zoom-in" data-aos-delay="200">
              <img src="assets/img/solo_Logo.png" class="img-fluid animated" alt="" width="300">
            </span>
            <span class="order-lg-1" data-aos="fade-up" data-aos-delay="200">
              <img src="assets/img/Solo_Ft.png" width="300" alt="">
              <div class="text-light mt-2">Transforma la Gestión del Talento en Ventaja Competitiva.</div>
            </span>
          </div>

          <div class="col-lg-5 d-flex flex-column mt-lg-4 pt-lg-4">  
            <div class="card mb-3 mt-lg-2 pt-lg-2">  
              <div class="card-body">  
                <div class="pt-4 text-center">
                  <h4 class="text-center fw-bold" style='color: #37517e;'>Iniciar Sesión</h4>
                </div>  
                <form class="row g-3" action="{{route('login')}}" method="post">
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
          </div>
        </div>
                

      </div>

    </section>



  
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      
    </div>
  </footer><!-- End Footer -->

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</html>
