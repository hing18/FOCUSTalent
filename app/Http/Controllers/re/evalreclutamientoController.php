<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class evalreclutamientoController extends Controller
{
    public function showForm($token) 
    {
        $tokenData = DB::table('evaluacion_reclutamiento_tokens')
            ->where('token', $token)
            ->first();

        // Verificar si ya se contestó
        $yaRespondido = DB::table('evaluacion_reclutamiento')
            ->where('token', $token)
            ->exists();

        if ($yaRespondido) {
            return response()->view('re.ya_enviado');
        }

        return view('re.evalreclutamiento', compact('token'));
    }

    public function submitForm(Request $request, $token)
    {
        $request->validate([
            'pregunta1' => 'required|integer|min:1|max:5',
            'pregunta2' => 'required|integer|min:1|max:5',
            'pregunta3' => 'required|integer|min:1|max:5',
            'pregunta4' => 'required|integer|min:1|max:5',
            'pregunta5' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string',
        ]);

        $tokenData = DB::table('evaluacion_reclutamiento_tokens')
            ->where('token', $token)
            
            ->first();

        DB::table('evaluacion_reclutamiento')->insert([
            'token'      => $token,
            'id_ofl'     => $tokenData->id_ofl,
            'jefe_email' => $tokenData->jefe_email,
            'pregunta1'  => $request->pregunta1,
            'pregunta2'  => $request->pregunta2,
            'pregunta3'  => $request->pregunta3,
            'pregunta4'  => $request->pregunta4,
            'pregunta5'  => $request->pregunta5,
            'comentarios'=> $request->comentarios,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->view('re.gracias');
    }
}