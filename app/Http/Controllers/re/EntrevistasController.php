<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\Entrevistas;
use App\Models\Re\PruebaApl;
use App\Models\Re\PruebaDisc;
use App\Models\Re\PruebaRazi;
use App\Models\re\Usr_part_curri_entrevistafun;
use App\Models\re\usr_part_obs_terna;
use App\Models\re\UsrPartCurriEntrevistapreg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntrevistasController extends Controller
{

    public function index()
    {
        $id_menu = 16;
        $id_menu_sup = 2;

        if (!isset(Auth::user()->id)) {
            return view('auth.login');
        }

        // Subconsulta: ofertas
        $ofertas = DB::table('usr_part_curri_entrevistafun')
            ->select('id_ofl', 'email_entrevistador',  DB::raw('count(*) as num_candidatos'))
            ->where('email_entrevistador', Auth::user()->email)
            ->whereNotNull('fecha')
            ->whereNotNull('hora')
            
            ->groupBy('id_ofl', 'email_entrevistador');

        // Subconsulta: ids máximos por oferta_id y email_destino
        $ultimasTernasIds = DB::table('ternas_enviadas as t1')
            ->selectRaw('MAX(t1.id) as id')
            ->groupBy('t1.oferta_id', 't1.email_destino');

        // Subconsulta: ternas completas
        $ultimasTernas = DB::table('ternas_enviadas as t1')
            ->joinSub($ultimasTernasIds, 'max_ternas', function ($join) {
                $join->on('t1.id', '=', 'max_ternas.id');
            })
            ->select(
                't1.id',
                't1.oferta_id',
                't1.email_destino',
                't1.email_reclutador'
                // agrega más campos si los necesitas
            );

        // Query principal
        $result_ofertas = DB::query()
            ->fromSub($ofertas, 'ofl')
            ->leftJoin('vacantes_solicitudes as vac', 'vac.id', '=', 'ofl.id_ofl')
            ->leftJoin('posiciones as pos', 'pos.id', '=', 'vac.id_puesto')
            ->leftJoin('estructuras as est', 'est.id', '=', 'pos.idue')
            ->leftJoinSub($ultimasTernas, 'ter', function ($join) {
                $join->on('ter.oferta_id', '=', 'ofl.id_ofl')
                    ->on('ter.email_destino', '=', 'ofl.email_entrevistador');
            })
            ->leftJoin('m_empleados as m', 'm.email', '=', 'ter.email_reclutador')
            ->where('ofl.email_entrevistador', Auth::user()->email)
            ->select(
                'ofl.id_ofl',
                'ofl.email_entrevistador',
                DB::raw("IF(vac.created_at IS NULL, '', DATE_FORMAT(vac.created_at, '%d-%m-%Y')) as f_solicitud"),
                'pos.descpue as nom_puesto',
                'vac.cantidad as vacantes',
                'ter.email_reclutador',
                'est.nameund as unidad',
                'ofl.num_candidatos',
                DB::raw("CONCAT(m.prinombre, ' ', m.priapellido) as nombre_reclutador")
            )
            ->orderByDesc('vac.updated_at')
            ->get();

            
        return view('re.entrevistas')
            ->with('id_menu', $id_menu)
            ->with('id_menu_sup', $id_menu_sup)
            ->with('ofertas', $result_ofertas);
    }

    public function list(Request $request)
    {
        
        if (!isset(Auth::user()->id)) {
            return view('auth.login');
        }

        // Subconsulta: ofertas
        $ofertas = DB::table('usr_part_curri_entrevistafun')
            ->select('id_ofl', 'email_entrevistador',  DB::raw('count(*) as num_candidatos'))
            ->where('email_entrevistador', Auth::user()->email)
            ->whereNotNull('fecha')
            ->whereNotNull('hora')
            
            ->groupBy('id_ofl', 'email_entrevistador');

        // Subconsulta: ids máximos por oferta_id y email_destino
        $ultimasTernasIds = DB::table('ternas_enviadas as t1')
            ->selectRaw('MAX(t1.id) as id')
            ->groupBy('t1.oferta_id', 't1.email_destino');

        // Subconsulta: ternas completas
        $ultimasTernas = DB::table('ternas_enviadas as t1')
            ->joinSub($ultimasTernasIds, 'max_ternas', function ($join) {
                $join->on('t1.id', '=', 'max_ternas.id');
            })
            ->select(
                't1.id',
                't1.oferta_id',
                't1.email_destino',
                't1.email_reclutador'
                // agrega más campos si los necesitas
            );

        // Query principal
        $result_ofertas = DB::query()
            ->fromSub($ofertas, 'ofl')
            ->leftJoin('vacantes_solicitudes as vac', 'vac.id', '=', 'ofl.id_ofl')
            ->leftJoin('posiciones as pos', 'pos.id', '=', 'vac.id_puesto')
            ->leftJoin('estructuras as est', 'est.id', '=', 'pos.idue')
            ->leftJoinSub($ultimasTernas, 'ter', function ($join) {
                $join->on('ter.oferta_id', '=', 'ofl.id_ofl')
                    ->on('ter.email_destino', '=', 'ofl.email_entrevistador');
            })
            ->leftJoin('m_empleados as m', 'm.email', '=', 'ter.email_reclutador')
            ->select(
                'ofl.id_ofl',
                'ofl.email_entrevistador',
                DB::raw("IF(vac.created_at IS NULL, '', DATE_FORMAT(vac.created_at, '%d-%m-%Y')) as f_solicitud"),
                'pos.descpue as nom_puesto',
                'vac.cantidad as vacantes',
                'ter.email_reclutador',
                'est.nameund as unidad',
                'ofl.num_candidatos',
                DB::raw("CONCAT(m.prinombre, ' ', m.priapellido) as nombre_reclutador")
            )
            ->orderByDesc('vac.updated_at')
            ->get();
           return response()->json($result_ofertas);
    }

    public function verCandidato(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['message' => 'ID de entrevista no especificado'], 400);
        }

        $entrevista = Usr_part_curri_entrevistafun::with([
                'curri:id,prinombre,priapellido,foto,genero,id_nacionalidad,email,tel,cv_doc',
                'curri.nacionalidad:id,nacionalidad',
            ])->find($id);

        if (!$entrevista) {
            return response()->json(['message' => 'Entrevista no encontrada'], 404);
        }

        $apl  = PruebaApl::where('curriculum_id', $entrevista->id_curri)->latest()->first();
        $disc = PruebaDisc::where('curriculum_id', $entrevista->id_curri)->latest()->first();
        $razi = PruebaRazi::where('curriculum_id', $entrevista->id_curri)->latest()->first();

        $obs = usr_part_obs_terna::where('id_curri', $entrevista->id_curri)
            ->where('id_part', $entrevista->id_part)
            ->where('id_ofl', $entrevista->id_ofl)
            ->latest()->first();

        if ($entrevista->preguntas_entrevistas == 1) {
            $preguntas = DB::table('usr_participantes as part')
                ->leftJoin('posiciones as pos', 'part.id_puesto', '=', 'pos.id')
                ->leftJoin('entrevistas_fun_preguntas as preg', 'preg.id_df', '=', 'pos.iddf')
                ->leftJoin('usr_part_curri_entrevistapreg as resp', function($join) use ($entrevista) {
                    $join->on('resp.id_pregunta', '=', 'preg.id')
                        ->where('resp.id_entrevistafun', '=', $entrevista->id);
                })
                ->where('part.id', $entrevista->id_part)
                ->select('preg.id', 'preg.pregunta', 'resp.respuesta')
                ->get();                

            $entrevista->preguntas = $preguntas;
        } else {
            $entrevista->preguntas = collect(); // mejor usar colección vacía
        }
        return response()->json([
            'success' => true,
            'entrevista' => $entrevista,
            'apl' => $apl?->informe,
            'disc' => $disc?->informe,
            'razi' => $razi?->informe,
            'obs' => $obs?->obs,
        ]);
    }

    public function saveEntrevistaFun(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'id' => 'required|integer|exists:usr_part_curri_entrevistafun,id',
            'valoracion' => 'required|integer|min:0|max:100',
            'comentarios' => 'required|string|min:10',
            'opt_candidato' => 'nullable|in:1,2,3',
            'respuestas' => 'required|array',
            'respuestas.*.pregunta' => 'required|string',
            'respuestas.*.id_pregunta' => 'required|integer',
            'respuestas.*.respuesta' => 'required|string',
        ]);

        // Buscar la entrevista
        $entrevista = Usr_part_curri_entrevistafun::find($validated['id']);
        if (!$entrevista) {
            return response()->json([
                'success' => false,
                'message' => 'Entrevista no encontrada.'
            ], 404);
        }

        // Guardar las respuestas
        foreach ($validated['respuestas'] as $respuesta) {
            UsrPartCurriEntrevistapreg::updateOrCreate(
                [
                    'id_entrevistafun' => $entrevista->id,
                    'id_pregunta' => $respuesta['id_pregunta'],
                    'pregunta' => $respuesta['pregunta'],
                ],
                [
                    'respuesta' => $respuesta['respuesta'],
                ]
            );
        }

        // Actualizar datos usando update
        $entrevista->update([
            'comentarios_entrevistador' => $validated['comentarios'],
            'valoracion' => $validated['valoracion'],
            'notifica_contratar' => $validated['opt_candidato'],
            'entrevista_realizada' => true,
            'f_realEntrevista' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Entrevista finalizada.',
            'entrevista' => $entrevista,
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
        */
    public function show(Request $request)
    {
        $id_ofl = $request->input('id_ofl');

        if (!$id_ofl) {
            return response()->json(['message' => 'ID de oferta no especificado'], 400);
        }

        Carbon::setLocale(app()->getLocale() ?? 'es');

        $entrevistas = Usr_part_curri_entrevistafun::query()
            ->select([
                'id',
                'id_curri',
                'id_part',
                'id_ofl',
                'fecha',
                'hora',
                'lugar_entrevista',
                'observaciones',
                'entrevista_realizada',
                'valoracion',
                'notifica_contratar',
                'entrevista_realizada',
                'f_realEntrevista'
            ])
            ->with([
                'curri:id,prinombre,priapellido,foto,genero,id_nacionalidad,email,tel',
                'curri.nacionalidad:id,nacionalidad',
                'participante:id,id_etapa',
                'ofl:id,id_puesto',
                'ofl.puesto:id,descpue',
            ])
            ->where('email_entrevistador', Auth::user()->email)
            ->where('id_ofl', $id_ofl)
            ->whereNotNull('fecha')
            ->whereNotNull('hora')
            ->whereHas('participante', fn ($q) => $q->where('id_etapa', 6))
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get()
            ->map(function ($item) {
                $item->fecha_corta = Carbon::parse($item->fecha)->format('Y-m-d');
                $item->fecha_formateada = ucfirst(Carbon::parse($item->fecha)->isoFormat('dddd D [de] MMMM YYYY'));   
                $item->fecha_real_formateada = ucfirst(Carbon::parse($item->f_realEntrevista)->isoFormat('dddd D [de] MMMM YYYY'));              
                

                if ($item->hora) {
                    try {
                        $hora = Carbon::parse($item->hora)->format('H:i:s');
                        $item->hora_formateada = Carbon::parse($hora)->format('h:i A');
                    } catch (\Exception $e) {
                        $item->hora_formateada = '';
                    }
                } else {
                    $item->hora_formateada = '';
                }

                return $item;
            });

        return response()->json($entrevistas);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrevistas $entrevistas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entrevistas $entrevistas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrevistas $entrevistas)
    {
        //
    }
}
