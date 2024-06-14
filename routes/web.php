<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\go\EstructuraContoller;
use App\Http\Controllers\go\PosicionesContoller;
use App\Http\Controllers\go\CompetenciasContoller;
use App\Http\Controllers\go\JerarquiasContoller;
use App\Http\Controllers\go\DescriptivosContoller;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\re\SolvacantesContoller;
use App\Http\Controllers\re\OfertasContoller;
use App\Http\Controllers\re\EntrevistasContoller;
use App\Http\Controllers\re\CurriculumContoller;
use App\Http\Controllers\conf\UsersContoller;
use App\Http\Controllers\conf\RolesContoller;
use App\Http\Controllers\emails\ContactanosController;

use App\Http\Controllers\DashboardContoller;
use App\Http\Controllers\re\CartapdfController;
use App\Mail\ContactanosMailable;
use App\Models\re\Entrevistas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { return view('auth.login');});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


//GESTIÓN ORGANIZATIVA

    Route::controller(EstructuraContoller::class)->group(function(){
        Route::get('estructura','index')->name('estructura');
        Route::get('unidades/create','create')->name('estructura.create');
        Route::get('unidades','unidades')->name('estructura.unidades');
        Route::post('unidades/procedimientos','muestra')->name('estructura.procedimientos');
        Route::put('unidades/update','update')->name('estructura.update');
    });

    Route::controller(CompetenciasContoller::class)->group(function(){
        Route::get('competencias','index')->name('competencias');
        Route::post('competencias/store','store')->name('competencias.store');
        Route::post('competencias/edit','edit')->name('competencias.edit');
        Route::post('competencias/update','update')->name('competencias.update');
        Route::post('competencias/destroy','destroy')->name('competencias.destroy');
    });

    Route::controller(JerarquiasContoller::class)->group(function(){
        Route::get('jerarquias','index')->name('jerarquias');
    });

    Route::controller(JerarquiasContoller::class)->group(function(){
        Route::get('jerarquias','index')->name('jerarquias');
        Route::post('jerarquias/store','store')->name('jerarquias.store');
        Route::post('jerarquias/edit','edit')->name('jerarquias.edit');
        Route::post('jerarquias/show','show')->name('jerarquias.show');
        Route::post('jerarquias/showcomp','showcomp')->name('jerarquias.showcomp');
        Route::post('jerarquias/update','update')->name('jerarquias.update');
        Route::post('jerarquias/destroy','destroy')->name('jerarquias.destroy');
        Route::post('jerarquias/destroycomp','destroycomp')->name('jerarquias.destroycomp');
        Route::post('jerarquias/create','create')->name('jerarquias.create');
    });

    Route::controller(DescriptivosContoller::class)->group(function(){
        Route::get('descriptivos','index')->name('descriptivos');
        Route::post('descriptivos/store','store')->name('descriptivos.store');
        Route::post('descriptivos/update','update')->name('descriptivos.update');
        Route::post('descriptivos/destroy','destroy')->name('descriptivos.destroy');
        Route::post('descriptivos/edit','edit')->name('descriptivos.edit');
        Route::post('descriptivos/update','update')->name('descriptivos.update');
    });

    Route::controller(PosicionesContoller::class)->group(function(){
        Route::get('posiciones','index')->name('posiciones');
        Route::post('posiciones/store','store')->name('posiciones.store');
        Route::post('posiciones/edit','edit')->name('posiciones.edit');
        Route::post('posiciones/update','update')->name('posiciones.update');
        Route::post('posiciones/destroy','destroy')->name('posiciones.destroy');
    });

    Route::controller(RegisterController::class)->group(function(){
        Route::get('registro','index')->name('registro');
    });

//RECLUTAMIENTO

    Route::controller(SolvacantesContoller::class)->group(function(){
        Route::get('vacantes','index')->name('solvacantes');
        Route::post('vacantes/show','show')->name('solvacantes.show');
        Route::post('vacantes/viewmotivo','viewmotivo')->name('solvacantes.viewmotivo');
        Route::post('vacantes/store','store')->name('solvacantes.store');
        Route::post('vacantes/ceco','ceco')->name('solvacantes.ceco');
    });
    
    Route::controller(OfertasContoller::class)->group(function(){
        Route::get('ofertas','index')->name('ofertas');
        Route::post('ofertas/show','show')->name('ofertas.show');        
        Route::post('ofertas/update','update')->name('ofertas.update');
        Route::post('ofertas/finddistcor','finddistcor')->name('ofertas.finddistcor');
        Route::post('ofertas/store','store')->name('ofertas.store');        
        Route::post('ofertas/edit','edit')->name('ofertas.edit');         
        Route::post('ofertas/destroy','destroy')->name('ofertas.destroy'); 
        Route::post('ofertas/findidcurri','findidcurri')->name('ofertas.findidcurri');    
        Route::post('ofertas/fin_respsico','fin_respsico')->name('ofertas.fin_respsico');    
        Route::post('ofertas/sigpaso','sigpaso')->name('ofertas.sigpaso');     
        Route::post('ofertas/deldoc','deldoc')->name('ofertas.deldoc');   
        Route::post('ofertas/fentrevist','fentrevist')->name('ofertas.fentrevist');
        Route::post('ofertas/notientre','notientre')->name('ofertas.notientre');
        Route::post('ofertas/destroyentre','destroyentre')->name('ofertas.destroyentre');
        Route::post('ofertas/pdf','pdf')->name('ofertas.pdf');
    });


    Route::controller(CartapdfController::class)->group(function(){
        Route::get('ofertas/PDFcartaoferta','index')->name('cartapdf');
    });

    Route::controller(EntrevistasContoller::class)->group(function(){
        Route::get('entrevistas','index')->name('entrevistas');
    });

//ADMINISTRACIÓN

    Route::controller(UsersContoller::class)->group(function(){
        Route::get('users','index')->name('users');
    });

    Route::controller(RolesContoller::class)->group(function(){
        Route::get('roles','index')->name('roles');
    });

    Route::controller(DashboardContoller::class)->group(function(){
        Route::get('dashboard','index')->name('dashboard');
    });


// ENVIO DE EMAIL

/*Route::get('contactanos', function(){
        Mail::to('mario.espinosa@itregencybrands.com')->send(new ContactanosMailable);
        return('Mensaje Enviado');
    })->name('contactanos');
    
    Route::controller(ContactanosController::class)->group(function(){
        Route::post('contactanos','store')->name('contactanos.store');
    });*/
   

    