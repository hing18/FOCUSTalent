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


       

    </head>
    <body>        

        @auth
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="row text-start">
                <div class="col-4 d-flex align-items-center">
                        <img src="{{ asset('assets/img/Ft2.png')}}" alt="" width="100%">
                   
                </div>

            </div><!-- End Logo -->
            
            
        </header><!-- End Header -->
   


                
            <div class="row m-0 vh-100 align-items-center justify-content-center" >
                <div class="col-3">  
                    <div class="card">  
                      <div class="card-body">  
                        <div class="pt-4 text-center">
                          <h4 class="text-center fw-bold" style='color: #37517e;'>Cambiar contraseña</h4>
                        </div>  
                        <form  id="formMain" class="row g-3" action="{{route('users.reset_pass')}}" method="post">
                          @csrf                          
                          <spam class="text-secondary">Nombre: {{ Auth::user()->name }}</spam>
                          <spam class="text-secondary">Email: {{ Auth::user()->email }}</spam>
                          <div class="col-12">
                            <label for="pass1" class="form-label">Nueva contraseña</label>
                            <div class="input-group ">
                              <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                              <input type="password" id="pass1" name="pass1" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-12">
                            <label for="pass2" class="form-label">Repetir Contraseña</label>
                            <div class="input-group ">
                              <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                              <input type="password" id="pass2" name="pass2" class="form-control" required>
                            </div>
                            
                          </div>
          
                          <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Cambiar</button>
                          </div>
                          <spam id="err" class="text-danger"> </spam>
                        </form>
                      </div>
                    </div>
                  </div>
            </div>
        @endauth
        <!-- Template Main JS File -->
    </body>
<script>
    formMain.addEventListener("submit", (e) => { // Escuchar cuando se envíe el formulario
  if (pass1.value !== pass2.value) { // Comprobar si los valores de los inputs son iguales, si no lo son continuar
    e.preventDefault(); // Prevenir que la página se recargue
    err.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Las contraseñas no coinciden'; // Notificar al usuario
    setTimeout(() => {
      err.innerHTML = " ";
    }, 1200); // Esperar 1.2 segundos y quitar el mensaje
  }
});
</script>


</html>
