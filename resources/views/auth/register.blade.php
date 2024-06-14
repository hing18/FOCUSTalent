<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Registrar Nuevo Usuario')


@section('content')




          
                  <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
        

        
                      <div class="card mb-3">
        
                        <div class="card-body">


        
                          <form class="row g-3 needs-validation" action="{{route('register')}}" method="post">
                            @csrf
                            
                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Nombre Completo</label>
                                <div class="input-group has-validation">
                                  <span class="input-group-text" id="inputGroupPrepend"><i class="far fa-user"></i></span>
                                  <input type="text" name="name" class="form-control" required>
                                  <div class="invalid-feedback">Por favor, ingrese el nombre completo!</div>
                                </div>
                            </div>

                            <div class="col-12">
                              <label for="yourUsername" class="form-label">Correo</label>
                              <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-at text-secondary"></i></span>
                                <input type="email" name="email" class="form-control" id="yourUsername" required>
                                <div class="invalid-feedback">Por favor, ingrese su correo!</div>
                              </div>
                            </div>
   
                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Código de Colaborador</label>
                                <div class="input-group has-validation">
                                  <span class="input-group-text" id="inputGroupPrepend"><i class="far fa-address-card"></i></span>
                                  <input type="text" name="codigo" class="form-control" id="yourUsername" required>
                                  <div class="invalid-feedback">Por favor, ingrese código de colaborador!</div>
                                </div>
                            </div>

                            <div class="col-12">
                              <label for="yourPassword" class="form-label">Contraseña</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                                    <div class="invalid-feedback">Por favor, ingrese la contraseña!</div>
                                </div>
                            </div>
        
                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback">Por favor, confirme la contraseña!</div>
                                    </div>
                            </div>

                            <div class="col-12">
                              <button class="btn btn-primary w-100" type="submit">Crear Cuenta</button>
                            </div>

                          </form>
        
                        </div>
                      </div>
        

        
                    </div>
                  </div>
         
                  @endsection
