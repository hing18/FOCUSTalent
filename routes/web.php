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
use App\Http\Controllers\gd\GapController;


use App\Http\Controllers\me\EmpleadosController;
use App\Http\Controllers\re\CurriculumController;
use App\Http\Controllers\rl\ContworkController;
use App\Http\Controllers\conf\UsersController;
use App\Http\Controllers\conf\RolesController;
use App\Http\Controllers\emails\ContactanosController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\gd\GapDirController;
use App\Http\Controllers\go\ProcedimientosController;
use App\Http\Controllers\re\bdController;
use App\Http\Controllers\re\CartapdfController;
use App\Http\Controllers\re\ConfigEntrevistasController;
use App\Http\Controllers\re\EscalasController;
use App\Http\Controllers\re\evalreclutamientoController;
use App\Http\Controllers\re\TernasController;
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
        Route::post('unidades/org', 'org')->name('estructura.org');
    });
 

    
    Route::controller(ProcedimientosController::class)
    ->middleware(['auth', 'session.expired'])    
    ->group(function(){
        Route::post('procedimientos/show','show')->name('procedimientos.show');
        Route::post('procedimientos/edit','edit')->name('procedimientos.edit');
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
        Route::post('vacantes/unidades','unidades')->name('solvacantes.unidades');
    });
    
    Route::controller(EscalasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('tiemporespuesta','index')->name('escalas');
        Route::post('tiemporespuesta/store','store')->name('escalas.store');
        Route::post('tiemporespuesta/destroy','destroy')->name('escalas.destroy');
        Route::post('tiemporespuesta/show','show')->name('escalas.show');
        Route::post('tiemporespuesta/update','update')->name('escalas.update');
        
        
    });

    Route::controller(OfertasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('ofertas','index')->name('ofertas');
        Route::post('ofertas/show','show')->name('ofertas.show');  
        Route::post('ofertas/reasignarReclutador','reasignarReclutador')->name('ofertas.reasignarReclutador');
        Route::post('ofertas/update','update')->name('ofertas.update');
        Route::post('ofertas/finddistcor','finddistcor')->name('ofertas.finddistcor');   
        Route::post('ofertas/edit','edit')->name('ofertas.edit');         
        Route::post('ofertas/destroy','destroy')->name('ofertas.destroy'); 
        Route::post('ofertas/findidcurri','findidcurri')->name('ofertas.findidcurri');    
        Route::post('ofertas/fin_respsico','fin_respsico')->name('ofertas.fin_respsico');    
        Route::post('ofertas/sigpaso','sigpaso')->name('ofertas.sigpaso');     
        Route::post('ofertas/deldoc','deldoc')->name('ofertas.deldoc');   
        Route::post('ofertas/fentrevist','fentrevist')->name('ofertas.fentrevist');
     
        Route::post('ofertas/destroyentre','destroyentre')->name('ofertas.destroyentre');
        //Route::post('ofertas/pdf','pdf')->name('ofertas.pdf');
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
        Route::post('ofertas/crearCartaOferta','crearCartaOferta')->name('ofertas.crearCartaOferta');
        Route::post('ofertas/editcartaoferta','editcartaoferta')->name('ofertas.editcartaoferta');
        Route::post('ofertas/tempUploadCartaOferta','tempUploadCartaOferta')->name('ofertas.tempUploadCartaOferta');
        Route::post('ofertas/saveCartaOfertaFinal','saveCartaOfertaFinal')->name('ofertas.saveCartaOfertaFinal');
        Route::post('ofertas/validaPaseFirma','validaPaseFirma')->name('ofertas.validaPaseFirma');
        Route::post('ofertas/sendfirmaContrato','sendfirmaContrato')->name('ofertas.sendfirmaContrato');
        
        Route::post('ofertas/pruebaspsico','pruebaspsico')->name('ofertas.pruebaspsico');
        Route::post('ofertas/destroypruebapsico','destroypruebapsico')->name('ofertas.destroypruebapsico');
        Route::post('ofertas/descarte','descarte')->name('ofertas.descarte');
        Route::post('ofertas/findcandidate','findcandidate')->name('ofertas.findcandidate');
        Route::post('ofertas/agregarcandidatos','agregarcandidatos')->name('ofertas.agregarcandidatos');        
        Route::post('ofertas/ver_det_candicate','ver_det_candicate')->name('ofertas.ver_det_candicate');  
        Route::post('ofertas/valida_ref','valida_ref')->name('ofertas.valida_ref'); 
        Route::post('ofertas/update_validacion_ref_p','update_validacion_ref_p')->name('ofertas.update_validacion_ref_p'); 
        Route::post('ofertas/update_validacion_ref_l','update_validacion_ref_l')->name('ofertas.update_validacion_ref_l');
        Route::post('ofertas/save_entrevista_ini','save_entrevista_ini')->name('ofertas.save_entrevista_ini');
        Route::post('ofertas/importardocs','importardocs')->name('ofertas.importardocs'); 
        Route::post('ofertas/deldocs','deldocs')->name('ofertas.deldocs'); 
        Route::post('ofertas/listar_candidate_terna','listar_candidate_terna')->name('ofertas.listar_candidate_terna');         
        Route::post('ofertas/addOBSTerna','addOBSTerna')->name('ofertas.addOBSTerna');
        Route::post('ofertas/editOBSTerna','editOBSTerna')->name('ofertas.editOBSTerna');
        Route::post('ofertas/msg_sendTerna','msg_sendTerna')->name('ofertas.msg_sendTerna');
        Route::post('ofertas/sendTerna','sendTerna')->name('ofertas.sendTerna');
        Route::post('ofertas/save_ent_funcional','save_ent_funcional')->name('ofertas.save_ent_funcional');
        Route::post('ofertas/viewEntFuncional','viewEntFuncional')->name('ofertas.viewEntFuncional');
        Route::post('ofertas/saveDescarte','saveDescarte')->name('ofertas.saveDescarte');        
        Route::post('ofertas/ceco','ceco')->name('ofertas.ceco');
    });

    Route::controller(TernasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){        
        Route::get('ternas','index')->name('ternas');  
        Route::post('ternas/verDetalle','verDetalle')->name('ternas.verDetalle');  
        Route::post('ternas/programarEntrevista','programarEntrevista')->name('ternas.programarEntrevista');
        Route::post('ternas/verEntrevista','verEntrevista')->name('ternas.verEntrevista'); 
        Route::post('ternas/declinarCandidato','declinarCandidato')->name('ternas.declinarCandidato');
        Route::post('ternas/verDeclinacion','verDeclinacion')->name('ternas.verDeclinacion');                 
    });

    

    Route::controller(bdController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('bd','index')->name('bd');
        Route::post('bd/subirfoto','subirfoto')->name('bd.subirfoto');
        Route::post('bd/findreg','findreg')->name('bd.findreg');       
        Route::post('bd/importarResultados','importarResultados')->name('bd.importarResultados');     
        Route::post('bd/importarResultadosrazi','importarResultadosrazi')->name('bd.importarResultadosrazi');    
        Route::post('bd/savepruebas','savepruebas')->name('bd.savepruebas');   
        Route::post('bd/eliminarPrueba','eliminarPrueba')->name('bd.eliminarPrueba');    
        Route::post('bd/store','store')->name('bd.store');     
        Route::post('bd/destroy','destroy')->name('bd.destroy');
    });
    
    Route::controller(ContworkController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('relacionesLaborales','index')->name('contwork');
        Route::post('relacionesLaborales/show','show')->name('rl.show');
        Route::post('relacionesLaborales/cartapdfcontrato','cartapdfcontrato')->name('rl.cartapdfcontrato');
        Route::post('relacionesLaborales/contratoPdf','contratoPdf')->name('rl.contratoPdf');
        Route::post('relacionesLaborales/PDFcontwork','PDFcontwork')->name('rl.PDFcontwork');
        Route::post('relacionesLaborales/tempUploadContrato','tempUploadContrato')->name('rl.tempUploadContrato');
        Route::post('relacionesLaborales/saveContratofirmado','saveContratofirmado')->name('rl.saveContratofirmado');
        Route::post('relacionesLaborales/porcontrato','porcontrato')->name('rl.porcontrato');
        
    });

    Route::controller(EntrevistasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('entrevistas','index')->name('entrevistas');
        Route::post('entrevistas/show','show')->name('entrevistas.show');
        Route::post('entrevistas/list','list')->name('entrevistas.list');
        Route::post('entrevistas/verCandidato','verCandidato')->name('entrevistas.verCandidato');
        Route::post('entrevistas/saveEntrevistaFun','saveEntrevistaFun')->name('entrevistas.saveEntrevistaFun');  
    });

    
    
    Route::controller(ConfigEntrevistasController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('ConfigEntrevistas','index')->name('entrevistasconfig');
        Route::post('ConfigEntrevistas/edit','edit')->name('entrevistasconfig.edit');//('procedimientos.edit');
        Route::post('ConfigEntrevistas/editpreg','editpreg')->name('entrevistasconfig.editpreg');//('procedimientos.editpreg');
        Route::post('ConfigEntrevistas/store','store')->name('entrevistasconfig.store');//('procedimientos.store');
        Route::post('ConfigEntrevistas/update','destroy')->name('entrevistasconfig.destroy');//('procedimientos.destroy');
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
        Route::post('evaluacion/leermas','leermas')->name('evaluacion.leermas');    
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
        Route::post('evaluados/cambiapuesto','cambiapuesto')->name('evaluacion.cambiapuesto');
        Route::post('evaluados/cambiaunidad','cambiaunidad')->name('evaluacion.cambiaunidad');
        Route::post('evaluados/cambianewpuesto','cambianewpuesto')->name('evaluacion.cambianewpuesto');
        
        Route::post('evaluados/levaldores','levaldores')->name('evaluacion.levaldores');
        Route::post('evaluados/mailevaluador','mailevaluador')->name('evaluacion.mailevaluador');
        Route::post('evaluados/resetpass','resetpass')->name('evaluacion.resetpass');
         
        Route::post('evaluados/evaluadores','evaluadores')->name('evaluacion.evaluadores');
        Route::post('evaluados/updateevaldor','updateevaldor')->name('evaluacion.updateevaldor');
        Route::post('evaluados','editstatus')->name('evaluacion.editstatus');
        Route::post('evaluados/print','print')->name('evaluados.print');    
        Route::post('evaluador','informe')->name('evaluacion.informe');
        Route::post('evaluacion/avances','avances')->name('evaluacion.avances');   
    });

    Route::controller(GapController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('Gap','index')->name('gap');       
    });

    Route::controller(GapDirController::class)
    ->middleware(['auth', 'session.expired'])
    ->group(function(){
        Route::get('gapunidad','index')->name('gapu'); 
        Route::post('gapunidad/show','show')->name('gapunidad.show');   
        Route::post('gapunidad/pid','pid')->name('gapunidad.pid');       
    });

// ENVIO DE EMAIL


Route::prefix('evaluacion-reclutamiento')->name('re.')->group(function () {

    // Vistas estáticas
    Route::get('ya-enviado', function () { return view('re.ya_enviado'); })->name('ya_enviado');

    Route::get('gracias', function () { return view('re.gracias'); })->name('gracias');

    // Evaluación con token
    Route::get('{token}', [evalreclutamientoController::class, 'showForm'])
        ->where('token', '[A-Za-z0-9]{60}')
        ->name('evalreclutamiento');

    Route::post('{token}', [evalreclutamientoController::class, 'submitForm'])
        ->where('token', '[A-Za-z0-9]{60}');
});



    