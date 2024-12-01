<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\go\EstructuraController;
use App\Http\Controllers\go\PosicionesController;
use App\Http\Controllers\go\CompetenciasController;
use App\Http\Controllers\go\JerarquiasController;
use App\Http\Controllers\go\DescriptivosController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\re\SolvacantesController;
use App\Http\Controllers\re\OfertasController;
use App\Http\Controllers\re\EntrevistasController;
use App\Http\Controllers\gd\EvaluacionController;
use App\Http\Controllers\gd\ConfevalController;


use App\Http\Controllers\me\EmpleadosController;
use App\Http\Controllers\re\CurriculumController;
use App\Http\Controllers\rl\ContworkController;
use App\Http\Controllers\conf\UsersController;
use App\Http\Controllers\conf\RolesController;
use App\Http\Controllers\emails\ContactanosController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\go\ProcedimientosController;
use App\Http\Controllers\re\CartapdfController;
use App\Mail\ContactanosMailable;
use App\Models\re\Entrevistas;
use App\Models\re\Ofertas;
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

//Route::get('/home', [HomeController::class, 'index'])->name('home');


//GESTIÓN ORGANIZATIVA

    Route::controller(EstructuraController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('estructura', 'index')->name('estructura');
        Route::get('unidades/create', 'create')->name('estructura.create');
        Route::get('unidades', 'unidades')->name('estructura.unidades');
        Route::put('unidades/update', 'update')->name('estructura.update');
    });
 

    
    Route::controller(ProcedimientosController::class)
    ->middleware(['auth', 'session.expired'])    
    ->group(function(){
        Route::post('procedimientos/show','show')->name('procedimientos.show');
    });

    Route::controller(CompetenciasController::class)
    ->middleware(['auth', 'session.expired'])    
    ->group(function(){
        Route::get('competencias','index')->name('competencias');
        Route::post('competencias/store','store')->middleware(['auth', 'check.session.expiration'])->name('competencias.store');
        Route::post('competencias/edit','edit')->name('competencias.edit');
        Route::post('competencias/update','update')->name('competencias.update');
        Route::post('competencias/destroy','destroy')->name('competencias.destroy');
    });

    Route::controller(JerarquiasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('jerarquias','index')->name('jerarquias');
    });

    Route::controller(JerarquiasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
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

    Route::controller(DescriptivosController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('descriptivos','index')->name('descriptivos');
        Route::post('descriptivos/store','store')->name('descriptivos.store');
        Route::post('descriptivos/update','update')->name('descriptivos.update');
        Route::post('descriptivos/destroy','destroy')->name('descriptivos.destroy');
        Route::post('descriptivos/edit','edit')->name('descriptivos.edit');
        Route::post('descriptivos/update','update')->name('descriptivos.update');
        Route::post('descriptivos/addtarea','addtarea')->name('descriptivos.addtarea');
        Route::post('descriptivos/destroyres','destroyres')->name('descriptivos.destroyres');
        Route::post('descriptivos/edit_respon','edit_respon')->name('descriptivos.edit_respon');
        
    });

    Route::controller(PosicionesController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('posiciones','index')->name('posiciones');
        Route::post('posiciones/store','store')->name('posiciones.store');
        Route::post('posiciones/edit','edit')->name('posiciones.edit');
        Route::post('posiciones/update','update')->name('posiciones.update');
        Route::post('posiciones/destroy','destroy')->name('posiciones.destroy');
    });

    Route::controller(RegisterController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('registro','index')->name('registro');
    });

//RECLUTAMIENTO

    Route::controller(SolvacantesController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('vacantes','index')->name('solvacantes');
        Route::post('vacantes/show','show')->name('solvacantes.show');
        Route::post('vacantes/viewmotivo','viewmotivo')->name('solvacantes.viewmotivo');
        Route::post('vacantes/store','store')->name('solvacantes.store');
        Route::post('vacantes/ceco','ceco')->name('solvacantes.ceco');
    });
    
    Route::controller(OfertasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
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
        Route::post('ofertas/cartapdf','cartapdf')->name('ofertas.cartapdf');
        Route::post('ofertas/subir','subir')->name('ofertas.subir');
        Route::post('ofertas/subirfoto','subirfoto')->name('ofertas.subirfoto');
        Route::post('ofertas/deldocofl','deldocofl')->name('ofertas.deldocofl');
        Route::post('ofertas/dependientes','dependientes')->name('ofertas.dependientes');
        Route::post('ofertas/destroydepend','destroydepend')->name('ofertas.destroydepend');
        Route::post('ofertas/contactos','contactos')->name('ofertas.contactos');
        Route::post('ofertas/destroycontacto','destroycontacto')->name('ofertas.destroycontacto');
        Route::post('ofertas/valsipe','valsipe')->name('ofertas.valsipe');
        Route::post('ofertas/valmarcacion','valmarcacion')->name('ofertas.valmarcacion');
        Route::post('ofertas/cartapdfcontrato','cartapdfcontrato')->name('ofertas.cartapdfcontrato');
        Route::post('ofertas/pruebaspsico','pruebaspsico')->name('ofertas.pruebaspsico');
        Route::post('ofertas/destroypruebapsico','destroypruebapsico')->name('ofertas.destroypruebapsico');
        Route::post('ofertas/descarte','descarte')->name('ofertas.descarte');
        
    });

    Route::controller(ContworkController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('contratos','index')->name('contwork');
        Route::post('contratos/show','show')->name('rl.show');
        Route::post('contratos/showfoto','showfoto')->name('rl.showfoto');
});
    Route::controller(EntrevistasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('entrevistas','index')->name('entrevistas');
    });

//ADMINISTRACIÓN

    Route::controller(UsersController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('users','index')->name('users');
        Route::post('users/reset_pass','reset_pass')->name('users.reset_pass');
    });

    Route::controller(RolesController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('roles','index')->name('roles');
    });

    Route::controller(DashboardController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('dashboard','index')->name('dashboard');
    });

    // EVALUACIÓN Y DESARROLLO
    Route::controller(EvaluacionController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('evaluacion','index')->name('evaluacion');
        Route::post('evaluacion/evaluado','evaluado')->name('evaluacion.evaluado');
        Route::post('evaluacion/showfoto','showfoto')->name('evaluacion.showfoto');
        Route::post('evaluacion/compcursos','compcursos')->name('evaluacion.compcursos');
        Route::post('evaluacion/save','save')->name('evaluacion.save');
        Route::post('evaluacion/print','print')->name('evaluacion.print');        
    });
    // ADMINISTRACIÓN DE PERSONAL
    Route::controller(EmpleadosController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('empleados','index')->name('empleados');
        Route::post('empleados/employee','employee')->name('empleados.employee');
        Route::post('empleados/subirfoto','subirfoto')->name('empleados.subirfoto');
    });

    Route::controller(ConfevalController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('config','index')->name('confeval');
         Route::post('evaluados/levaldos','levaldos')->name('evaluacion.levaldos');
         Route::post('evaluados/levaldores','levaldores')->name('evaluacion.levaldores');
         Route::post('evaluados/mailevaluador','mailevaluador')->name('evaluacion.mailevaluador');
         Route::post('evaluados/resetpass','resetpass')->name('evaluacion.resetpass');
         
         Route::post('evaluados/evaluadores','evaluadores')->name('evaluacion.evaluadores');
         Route::post('evaluados/updateevaldor','updateevaldor')->name('evaluacion.updateevaldor');
         Route::post('evaluados','editstatus')->name('evaluacion.editstatus');
    });
// ENVIO DE EMAIL

/*Route::get('contactanos', function(){
        Mail::to('mario.espinosa@itregencybrands.com')->send(new ContactanosMailable);
        return('Mensaje Enviado');
    })->name('contactanos');
    
    Route::controller(ContactanosController::class)->group(function(){
        Route::post('contactanos','store')->name('contactanos.store');
    });*/
   

    