<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfigEntrevistasController extends Controller
{
    public function index()
    {
        $id_menu = 30;
        $id_menu_sup = 2;

        // Verificar usuario autenticado
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $id_user = $user->id;

        // Verificar si el usuario tiene acceso al menú
        $hasAccess = DB::table('usr_rol as ur')
            ->join('rol_menu as rm', function ($join) use ($id_menu) {
                $join->on('rm.id_rol', '=', 'ur.id_rol')
                    ->where('rm.id_menu', $id_menu);
            })
            ->where('ur.id_usr', $id_user)
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('login');
        }

        // Obtener datos de estructuras principales
        $data_sups = DB::table('estructuras')->where('id_sup', 0)->get();
        return view('re.entrevistasconfig', compact('data_sups', 'id_menu', 'id_menu_sup'));
    }

    public function edit(Request $request)
    {
        $idf = $request->input('idf');

        // Proposito de la descripción
        $proposito = DB::table('descriptivos')
            ->where('id', $idf)
            ->select('proposito')
            ->first();

        // Preguntas asociadas
        $preguntas = DB::table('entrevistas_fun_preguntas')
            ->where('id_df', $idf)
            ->select('id', 'pregunta')
            ->get();
        
        $query_respon = DB::select(
            "SELECT id as id_respon, area_respon, kpi, cant_tarea
            FROM descrip_area_respon
            WHERE iddf = ?", [$idf]
        );

        $query_tareas = DB::select(
            "SELECT tareas.idarearespon, tareas.tarea, tareas.criticidad
            FROM descrip_area_respon as respon
            LEFT JOIN descrip_area_respon_tareas as tareas ON (respon.id = tareas.idarearespon)
            WHERE respon.iddf = ?
            ORDER BY tareas.id", [$idf]
        );
            
        
        return response()->json([
            'success'   => true,
            'proposito' => $proposito ? $proposito->proposito : null,
            'preguntas' => $preguntas,
            'respons'   => $query_respon,
            'tareas'    =>  $query_tareas,

        ]);
    }

    public function store(Request $request)
    {
        $idf = $request->input('idf');
        $nueva_pregunta = $request->input('nueva_pregunta');

        if (!$idf || !$nueva_pregunta) {
            return response()->json([
                'success' => false,
                'message' => 'ID de función o pregunta no proporcionada.'
            ]);
        }

        // Insertar la nueva pregunta en la base de datos
        $insertedId = DB::table('entrevistas_fun_preguntas')->insertGetId([
            'id_df' => $idf,
            'pregunta' => $nueva_pregunta
        ]);

        if ($insertedId) {
            return response()->json([
                'success' => true,
                'message' => 'Pregunta agregada exitosamente.',
                'pregunta' => [
                    'id' => $insertedId,
                    'pregunta' => $nueva_pregunta
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar la pregunta.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $id_pregunta = $request->input('idpreg');

        if (!$id_pregunta) {
            return response()->json([
                'success' => false,
                'message' => 'ID de pregunta no proporcionada.'
            ]);
        }

        // Eliminar la pregunta de la base de datos
        $deleted = DB::table('entrevistas_fun_preguntas')
            ->where('id', $id_pregunta)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Pregunta eliminada exitosamente.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la pregunta.'
            ]);
        }
    }

    public function editpreg(Request $request)
    {
        $id_pregunta = $request->input('idpreg');
        $nueva_pregunta = $request->input('nueva_pregunta');

        if (!$id_pregunta || !$nueva_pregunta) {
            return response()->json([
                'success' => false,
                'message' => 'ID de pregunta o nueva pregunta no proporcionada.'
            ]);
        }

        // Actualizar la pregunta en la base de datos
        $updated = DB::table('entrevistas_fun_preguntas')
            ->where('id', $id_pregunta)
            ->update(['pregunta' => $nueva_pregunta]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Pregunta actualizada exitosamente.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se realizaron cambios en la pregunta.'
            ]);
        }
    }
}