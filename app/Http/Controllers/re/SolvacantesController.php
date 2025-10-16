<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Jobs\EnviarSolicitudRecibidaJob;
use App\Mail\SolicitudRecibidaMail;
use App\Models\conf\Users;
use App\Models\re\Solvacantes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SolvacantesController extends Controller
{
 
    public function index()
    {
        $id_menu = 3;
        $id_menu_sup = 2;

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $id_user = $user->id;

        // Verificar permisos del usuario
        $rolMenu = DB::table('usr_rol as ur')
            ->join('rol_menu as rm', function($join) use ($id_menu) {
                $join->on('rm.id_rol', '=', 'ur.id_rol')
                    ->where('rm.id_menu', $id_menu);
            })
            ->where('ur.id_usr', $id_user)
            ->select('rm.id_menu', 'ur.id_rol')
            ->first();

        if (!$rolMenu) {
            return redirect()->route('login');
        }

        $data_rol = $rolMenu->id_rol;

        // Mostrar sección confidencial solo para roles 1 y 4
        $show_conficencial = in_array($data_rol, [1, 4]) ? '' : 'd-none';

        // Datos de unidades asignadas al usuario
        $data_sups = DB::table('rec_usr_ue as r')
            ->leftJoin('v_unidades_estructura_hc as v', function($join) {
                $join->on('r.id_grupo', '=', 'v.idgrupo')
                    ->on('r.tienda', '=', 'v.tienda');
            })
            ->where('r.id_usr', $id_user)
            ->groupBy('v.idgrupo', 'v.grupo', 'v.tienda')
            ->orderBy('v.idgrupo')
            ->select('v.idgrupo', 'v.grupo', 'v.tienda')
            ->get();

        // Datos de motivos, género y edades para vacantes
        $data_vacantes_motivo = DB::table('vacantes_motivo')
            ->where('status', 'true')
            ->select('id', 'motivo')
            ->get();

        $data_vacantes_genero = DB::table('vacantes_genero')
            ->select('id', 'letra', 'genero')
            ->get();

        $data_vacantes_edades = DB::table('vacantes_edades')
            ->where('status', 'true')
            ->select('id', 'rango')
            ->get();

        return view('re.solvacantes', compact(
            'data_sups',
            'show_conficencial',
            'id_menu',
            'id_menu_sup',
            'data_vacantes_motivo',
            'data_vacantes_genero',
            'data_vacantes_edades'
        ));
    }


    public function unidades(Request $request)
    {
        $data= request()->except('_token');
        $idgrp= $data['idgrp'];
        $id_user = Auth::user()->id;

        [$idgrupo, $tienda] = explode('-', $data['idgrp']);
            $data_unidades = DB::select("
            SELECT DISTINCT 
                v.idunidad, v.unidad, v.tienda 
            FROM 
                rec_usr_ue r 
            LEFT JOIN 
                v_unidades_estructura_hc v ON (r.id_grupo = v.idgrupo AND r.tienda = v.tienda)
            WHERE 
                r.id_usr = :id_user 
                AND r.id_grupo = :idgrupo 
                AND r.tienda = :tienda
            ORDER BY 
                v.unidad", ['id_user' => $id_user, 'idgrupo' => $idgrupo, 'tienda' => $tienda,
            ]);

        if (empty($data_unidades)) {
            return response()->json([
                'code' => 403,
                'message' => 'No tiene acceso a las unidades del grupo indicado.'
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Unidades obtenidas correctamente.',
            'data' => [
                'data_unidades' => $data_unidades,
                'tipogrp' => $tienda,
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $comentarios = preg_replace('/[^\w.\s\n\r]/u', '', $request->input('comentarios', ''));
        $sube = 0;
        $newnamecompleto = '-';

        // Manejo del archivo si existe
        if ($request->hasFile('fileToUpload') && $request->file('fileToUpload')->isValid()) {
            $archivo = $request->file('fileToUpload');
            $filename = 'autorizacion_' . time() . '.' . $archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('auth', $filename, 'public'); // storage/app/public/docs
            $newnamecompleto = 'storage/' . $ruta;
            $sube = 1;
        }
        
        // Crear la solicitud
        if ($sube == 0 || $sube == 1) {
            $fecha_actual = now();
            $fecha_hasta = $fecha_actual->copy()->addDays($request->tiempocalculado);
            $new = new Solvacantes();
            $new->id_puesto = $request->id_puesto;
            $new->codigo_puesto = $request->codigo_puesto;
            $new->cantidad = $request->cantidad;
            $new->proceso = 0;
            $new->contratados = 0;
            $new->genero = $request->genero;
            $new->rango_edad = $request->rango_edad;
            $new->comentarios = $comentarios;
            $new->id_secc = $request->id_secc;
            $new->id_ue = $request->id_ue;
            $new->id_jer = $request->id_jer;
            $new->id_estatus = 1;
            $new->id_escala = $request->id_escala;
            $new->tiemporeal = $request->tiemporeal;
            $new->tiempocalculado = $request->tiempocalculado;
            $new->hasta = $fecha_hasta->format('Y-m-d');
            $new->id_motivo = $request->id_motivo;
            $new->autorizacion = $newnamecompleto;
            $new->confidencial = $request->confidencial;
            if($request->confidencial==1){  $new->reclutador_asignado = Auth::id(); }
            $new->min_salario = $request->min_salarial;
            $new->max_salario = $request->max_salarial;
            $new->id_user_solicitante = Auth::id();
            $new->save();
        }
        // Calcular total de vacantes activas para ese puesto
        if(Auth::user()->rol==1)
        {
            $totcantidad = DB::table('vacantes_solicitudes as vacsol')
            ->where('vacsol.id_puesto', $request->id_puesto)
            ->where('vacsol.id_estatus', '<', 10)// Abiertas o en Proceso
            ->whereRaw('vacsol.contratados < vacsol.cantidad')
            ->sum('vacsol.cantidad');}
        else{
            $totcantidad = DB::table('vacantes_solicitudes as vacsol')
            ->where('vacsol.id_puesto', $request->id_puesto)
            ->where('vacsol.id_estatus', '<', 4)
            ->whereRaw('vacsol.contratados < vacsol.cantidad')
            ->where(function($query) {
                $query->where('vacsol.confidencial', 0)
                    ->orWhere(function($q) {
                        $q->where('vacsol.confidencial', 1)
                            ->where('vacsol.reclutador_asignado', Auth::id());
                    });
            })
            ->sum('vacsol.cantidad');
        }


        $usuario = Auth::user();
        $Nomb_puesto = DB::table('posiciones')->where('id', $request->id_puesto)->value('descpue');

        exec('start /B php ' . base_path('artisan') . ' mail:solicitud "' . $usuario->email . '" "' . $usuario->name . '" "' . $Nomb_puesto . '"');

        // Datos de la solicitud
        $solicitudData = (object)[
            'id' => $new->id,
            'jefe_nombre' => $usuario->name,
            'puesto' => $Nomb_puesto,
            'fecha_envio' => Carbon::now(),
            'comentarios' => $request->comentarios,
            'cantidad' => $request->cantidad,
        ];
        
        $solicitudJson = addslashes(json_encode($solicitudData));

        $reclutadores_emails = \App\Models\User::where('rol', 4)->pluck('email')->toArray();
        foreach ($reclutadores_emails as $emails) {
            exec('start /B php ' . base_path('artisan') . ' mail:reclutador "' . $emails . '" "' . $solicitudJson . '"');
        }

        return response()->json([
            "success" => true,
            "totcantidad" => $totcantidad,
            "sube" => $sube,
            "mensaje" => "Solicitud creada correctamente"
        ]);
    }

    public function show(Solvacantes $solvacantes)
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        $id_pue = (int) request('id_pue');
        // 1. Obtener datos principales
        $posicion = DB::table('vw_pue_est_jer_tiempo')->where('idpu', $id_pue)->select('proposito','idjer','idue','iduni','iddf','id_escala','tiempo')->first();
        // 2. Obtener competencias
        $competencias = DB::table('posiciones as po')
        ->join('descriptivos as df', 'po.iddf', '=', 'df.id')
        ->leftJoin('reljercomp as rel', 'rel.idjer', '=', 'df.idjer')
        ->leftJoin('competencias as comp', 'rel.idcomp', '=', 'comp.id')
        ->where('po.id', $id_pue)
        ->select(
            'comp.id',
            'comp.nombre',
            'rel.esperado as perfil',            
            DB::raw("
                CASE rel.idtipocomp
                    WHEN 1 THEN 'Crítica'
                    WHEN 2 THEN 'Muy Importante'
                    WHEN 3 THEN 'Importante'
                    ELSE 'No definido'
                END as nomtipocomp
            "),
            'color'
        )
        ->orderBy('rel.idtipocomp')
        ->orderBy('comp.nombre')
        ->get();
        $habilidades= DB::select("SELECT habi.habilidad, habi.nivel
        FROM descrip_habilidades as habi
        WHERE habi.iddf = $posicion->iddf
        ORDER BY habi.id");
        // 3. Consolidar datos
        $result = [
            'proposito'   => $posicion->proposito,
            'idjer'       => $posicion->idjer,
            'idue'        => $posicion->idue,
            'iduni'       => $posicion->iduni,
            'tiempo'      => $posicion->tiempo   ?? null,
            'id_escala'   => $posicion->id_escala ?? null,
            'competencias'=> $competencias,
            'habilidades' => $habilidades,
        ];
        return response()->json($result);
    }

    public function viewmotivo(Request $request)
    {
        $data= request()->except('_token');
        $id_motivo= $data['id_motivo'];
        $data_vacantes_motivo=DB::select("SELECT necesita_autorizacion FROM vacantes_motivo WHERE id=$id_motivo");
        foreach ($data_vacantes_motivo as $r)
        {   $necesita=$r->necesita_autorizacion;}
        $salidaJson=array("necesita"=>$necesita);
        echo(json_encode($salidaJson));
    }



    public function update(Request $request, Solvacantes $solvacantes)
    {
        //
    }

    public function destroy(Solvacantes $solvacantes)
    {
        //
    }
}
