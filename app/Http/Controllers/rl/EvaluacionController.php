<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    public function showForm($token)
    {
        $registro = DB::table('evaluacion_reclutamiento_tokens')
            ->where('token', $token)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$registro) {
            abort(404);
        }

        return view('evaluacion.formulario', [
            'token' => $token,
            'empleado_id' => $registro->empleado_id
        ]);
    }

    public function submitForm(Request $request, $token)
    {
        // Validar token nuevamente
        $registro = DB::table('evaluacion_reclutamiento_tokens')
            ->where('token', $token)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$registro) {
            abort(404);
        }

        // Validar formulario
        $request->validate([
            'comentarios' => 'required|string',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        // Guardar evaluación (crear tabla si no existe)
        DB::table('evaluaciones_reclutamiento')->insert([
            'empleado_id' => $registro->empleado_id,
            'jefe_id' => $registro->jefe_id,
            'comentarios' => $request->comentarios,
            'calificacion' => $request->calificacion,
            'created_at' => now(),
        ]);

        // Eliminar token para que no se reutilice
        DB::table('evaluacion_reclutamiento_tokens')->where('token', $token)->delete();

        return view('evaluacion.gracias'); // página de agradecimiento
    }
}
