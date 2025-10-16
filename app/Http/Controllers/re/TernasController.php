<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\Usr_part_curri_entrevistafun;
use App\Models\re\usr_participantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class TernasController extends Controller
{
    // Mostrar lista de ternas
    public function index()
    {
        $id_menu = 29;
        $id_menu_sup = 2;

        $email = Auth::user()->email;

        // Subconsulta: última fecha de envío por oferta + destinatario
        $subMaxFecha = DB::table('ternas_enviadas')
            ->select('oferta_id', 'email_destino', DB::raw('MAX(created_at) as max_fecha'))
            ->where('email_destino', $email)
            ->groupBy('oferta_id', 'email_destino');

        // Subconsulta: total de envíos por oferta + destinatario
        $subTotalEnvios = DB::table('ternas_enviadas')
            ->select('oferta_id', DB::raw('COUNT(*) as total_envios'))
            ->where('email_destino', $email)
            ->groupBy('oferta_id');

        // Subconsulta: total de candidatos enviados por oferta (etapas entre 5 y 11)
        $subCandidatos = DB::table('terna_candidatos as cant')
            ->leftJoin('usr_participantes as part', function ($join) {
                $join->on('cant.id_curri', '=', 'part.id_part_curriculum')
                    ->on('cant.id_ofl', '=', 'part.id_ofl');
            })
            ->select(
                'cant.id_ofl',
                'cant.email_entrevistador',
                DB::raw('COUNT(*) as total_candidatos')
            )
            ->where('cant.email_entrevistador', $email)
            ->where('part.id_etapa', '>=', 5)
            ->where('part.id_etapa', '<', 12)
            ->groupBy('cant.id_ofl', 'cant.email_entrevistador');

        // Consulta principal
        $data_ternas = DB::table('ternas_enviadas as t')
            ->leftJoin('vacantes_solicitudes as ofl', 'ofl.id', '=', 't.oferta_id')
            ->leftJoin('posiciones as p', 'p.id', '=', 'ofl.id_puesto')
            ->leftJoin('estructuras as e', 'e.id', '=', 'p.idue')
            ->leftJoin('m_empleados as m', DB::raw('CONVERT(t.email_reclutador USING utf8mb4)'), '=', DB::raw('CONVERT(m.email USING utf8mb4)'))
            ->leftJoinSub($subTotalEnvios, 't3', function ($join) {
                $join->on('t3.oferta_id', '=', 't.oferta_id');
            })
            ->leftJoinSub($subCandidatos, 'cant', function ($join) {
                $join->on('cant.id_ofl', '=', 't.oferta_id')
                    ->on('cant.email_entrevistador', '=', 't.email_reclutador');
            })
            ->joinSub($subMaxFecha, 'latest', function ($join) {
                $join->on('latest.oferta_id', '=', 't.oferta_id')
                    ->on('latest.email_destino', '=', 't.email_destino')
                    ->on('latest.max_fecha', '=', 't.created_at');
            })
            ->where('t.email_destino', $email)
            ->where('t.estatus', 1)
            ->select(
                't.id',
                't.oferta_id',
                'cant.total_candidatos',
                't.email_destino',
                DB::raw("IF(t.created_at IS NULL, '', DATE_FORMAT(t.created_at, '%d-%m-%Y')) as fecha_Terna"),
                't3.total_envios',
                'ofl.cantidad as solicitados',
                DB::raw("IF(ofl.created_at IS NULL, '', DATE_FORMAT(ofl.created_at, '%d-%m-%Y')) as fsolicitud"),
                'p.descpue as nom_puesto',
                'e.nameund as unidad',
                't.email_reclutador',
                DB::raw("
                    CONCAT(
                        UPPER(LEFT(m.prinombre, 1)), LOWER(SUBSTRING(m.prinombre, 2)), ' ',
                        UPPER(LEFT(m.priapellido, 1)), LOWER(SUBSTRING(m.priapellido, 2))
                    ) as nombre_completo
                ")
            )
            ->get();

            $fecha_ternas = DB::table('ternas_enviadas as t')
                ->where('t.email_destino', $email)
                ->select(
                    't.oferta_id',
                    DB::raw("IF(t.created_at IS NULL, '', DATE_FORMAT(t.created_at, '%b %d, %Y')) as fecha_Terna")
                )
                ->orderBy('t.created_at', 'asc')
                ->get();
;


        return view('re.ternas')
            ->with('data_ternas', $data_ternas)
            ->with('fecha_ternas', $fecha_ternas)
            ->with('id_menu', $id_menu)
            ->with('id_menu_sup', $id_menu_sup);
    }




    public function verDetalle(Request $request)
    {
        $ternaId = $request->input('id_terna');
        $terna = DB::table('ternas_enviadas')->where('id', $ternaId)->first();

        if (!$terna) {
            abort(404, 'Terna no encontrada');
        }
        $id_ofl = $terna->oferta_id;
        $jerarquia = DB::table('vacantes_solicitudes as ofl')
        ->leftJoin('posiciones as p', 'ofl.id_puesto', '=', 'p.id')
        ->leftJoin('descriptivos as df', 'df.id', '=', 'p.iddf')
        ->leftJoin('jerarquias as j', 'j.id', '=', 'df.idjer')
        ->where('ofl.id', $id_ofl)
        ->selectRaw("CONCAT(UPPER(LEFT(j.nombrejer, 1)), LOWER(SUBSTRING(j.nombrejer, 2))) AS jerarquia")
        ->value('jerarquia');

        
        $idsCurris = [];
        if (!empty($terna->candidatos)) {
            $idsCurris = json_decode(DB::table('terna_candidatos')->select('id_curri')->where('id_ofl', $id_ofl)->get(), true);
        }
            $competencias = DB::table('vacantes_solicitudes as s')
                ->leftJoin('posiciones as p', 's.id_puesto', '=', 'p.id')
                ->leftJoin('descriptivos as d', 'p.iddf', '=', 'd.id')
                ->leftJoin('reljercomp as r', 'd.idjer', '=', 'r.idjer')
                ->leftJoin('competencias as com', 'r.idcomp', '=', 'com.id')
                ->select(
                    's.id as id_ofl',
                    'com.id as id_competencia',
                    DB::raw("CONCAT(UPPER(LEFT(com.nombre, 1)), LOWER(SUBSTRING(com.nombre, 2))) AS competencia"),
                    'r.idtipocomp as tipo',
                    'r.esperado',
                    'com.color'
                )
                ->where('s.id', $id_ofl)
                ->orderBy('r.idtipocomp', 'asc')
                ->get();

                $idsCompetencias = $competencias->pluck('id_competencia');
                if ($idsCompetencias->isEmpty()) {
                    return response()->json(['success' => true, 'id_apl' => []]);
                }

            // Subconsulta para traer el último informe APL por currículum
                $ult_pruebas_apl = DB::table('pruebas_apl as apl')
                    ->select(
                        'apl.id AS id_apl'
                    )
                    ->whereIn('apl.curriculum_id', $idsCurris)
                    ->whereRaw('apl.fecha_realizada = (
                        SELECT MAX(fecha_realizada)
                        FROM pruebas_apl
                        WHERE curriculum_id = apl.curriculum_id)'
                    )
                    ->get();

                $idsPruebasApl = $ult_pruebas_apl->pluck('id_apl');
                    if ($idsPruebasApl->isEmpty()) {
                        return response()->json(['success' => true, 'id_apl' => []]);
                    }


                $resultados_competencias_apl = DB::table('pruebas_apl as apl')
                    ->leftJoin('pruebas_resultados_apl as res', 'res.prueba_id', '=', 'apl.id')
                    ->select(
                        'apl.curriculum_id AS id_curri',
                        'res.competencia_id',
                        'res.puntaje'
                    )
                    ->whereIn('res.competencia_id', $idsCompetencias)
                    ->whereIn('apl.id', $idsPruebasApl)
                    ->get();


                $participantes = DB::table('usr_part_curriculum as curri')
                        ->leftJoin('usr_nacionalidad as n', 'n.id', '=', 'curri.id_nacionalidad')
                        ->leftJoin('usr_participantes as p', 'p.id_part_curriculum', '=', 'curri.id')
                        ->leftJoin('usr_part_obs_terna as obst', 'obst.id_part', '=', 'p.id')
                        ->leftJoin('usr_part_curri_entrevistafun as entfun', function ($join) {
                            $join->on('entfun.id_curri', '=', 'curri.id')
                                ->on('entfun.id_ofl', '=', 'p.id_ofl')
                                ->where('entfun.email_entrevistador', '=', Auth::user()->email);
                        })
                        ->selectRaw("
                            p.id as id_part,
                            curri.id as id_curri,
                            IF(curri.foto IS NULL, 
                                IF(curri.genero = 'M', 'storage/fotos/el.png', 'storage/fotos/ella.png'), 
                                curri.foto
                            ) AS foto_mostrar,
                            CONCAT(UPPER(LEFT(curri.prinombre, 1)), LOWER(SUBSTRING(curri.prinombre, 2))) AS prinombre,
                            CONCAT(UPPER(LEFT(curri.priapellido, 1)), LOWER(SUBSTRING(curri.priapellido, 2))) AS priapellido,
                            p.id_etapa,
                            p.motivo_descarte,
                            curri.email,
                            curri.tel,
                            CONCAT(UPPER(LEFT(n.nacionalidad, 1)), LOWER(SUBSTRING(n.nacionalidad, 2))) AS nacionalidad,
                            curri.cv_doc,
                            IF(obst.obs IS NULL, '', TRIM(obst.obs)) AS obs, 
                            entfun.id AS id_entrevista,
                            entfun.fecha AS fecha_entrevista,
                            entfun.entrevista_realizada,
                            entfun.notifica_contratar,
                            entfun.f_realEntrevista,
                           
                            
                            IF(entfun.lugar_entrevista IS NULL, '', entfun.lugar_entrevista) AS lugar_entrevista,
                            IF(entfun.observaciones IS NULL, '', entfun.observaciones) AS observaciones
                        ")
                        ->whereIn('curri.id', $idsCurris)
                        ->where('p.id_ofl', $id_ofl)
                        ->get()
                        ->map(function ($item) {
                            
                            if (!is_null($item->f_realEntrevista)) {
                                $item->fecha_real_formateada = ucfirst(Carbon::parse($item->f_realEntrevista)->isoFormat('dddd D [de] MMMM YYYY'));
                                } else {
                                    $item->fecha_real_formateada = null;
                                }           
                            return $item;
                        });

                $ult_result_apl = DB::select('CALL AnalisisAplTerna(?)', [$id_ofl]);

                $ult_pruebas_razi = DB::table('pruebas_razi as razi')
                    ->select('razi.id AS id_razi', 
                        'razi.curriculum_id AS id_curri',
                        'razi.fecha_realizada', 
                        'razi.puntaje_v', 
                        'razi.puntaje_n', 
                        'razi.puntaje_a', 
                        'razi.general', 
                        'razi.preg_acertadas', 
                        'razi.informe')
                    ->whereIn('razi.curriculum_id', $idsCurris)
                    ->whereRaw('razi.fecha_realizada = (SELECT MAX(fecha_realizada) FROM pruebas_razi WHERE curriculum_id = razi.curriculum_id)')
                    ->orderByDesc('razi.general')
                    ->get();

                $ult_pruebas_disc = DB::table('pruebas_disc as disc')
                    ->select('disc.id AS id_disc',
                        'disc.curriculum_id AS id_curri',
                        'disc.fecha_realizada AS fecha_max',
                        'disc.puntaje_d',
                        'disc.puntaje_i',
                        'disc.puntaje_s',
                        'disc.puntaje_c', 
                        'disc.informe')
                    ->whereIn('disc.curriculum_id', $idsCurris)
                    ->whereRaw('disc.fecha_realizada = (SELECT MAX(fecha_realizada) FROM pruebas_disc WHERE curriculum_id = disc.curriculum_id)')
                    ->get();
                    
                $ult_pruebas_veritas = DB::table('pruebas_veritas as veritas')
                    ->select('veritas.id AS id_disc',
                        'veritas.curriculum_id AS id_curri',
                        'veritas.fecha_realizada AS fecha_max',
                        'veritas.puntaje')
                    ->whereIn('veritas.curriculum_id', $idsCurris)
                    ->whereRaw('veritas.fecha_realizada = (SELECT MAX(fecha_realizada) FROM pruebas_veritas WHERE curriculum_id = veritas.curriculum_id)')
                    ->orderBy('veritas.puntaje', 'asc')
                    ->get();
                

        
            return response()->json([
            'success' => true,
            'terna' => $terna,
            'id_ofl' => $id_ofl,
            'participantes' => $participantes,
            'competencias' => $competencias,
            'ult_pruebas_apl' => $ult_result_apl,
            'resultados_competencias_apl' => $resultados_competencias_apl,
            'ult_pruebas_razi' => $ult_pruebas_razi,
            'ult_pruebas_disc' => $ult_pruebas_disc,
            'ult_pruebas_veritas' => $ult_pruebas_veritas,
            'jerarquia' => $jerarquia,
            ]);

    }

    public function programarEntrevista(Request $request)
    {
        $request->validate([
            'id_terna' => 'required|integer',
            'id_ofl' => 'required|integer',
            'id_curri' => 'required|integer',
            'id_part' => 'required|integer',

            
            'lugar_entrevista' => 'required|string',
            'nom_posicion' => 'required|string',
            'nom_unidad' => 'required|string',
            'candidato' => 'required|string',
            'email_reclutador' => 'required|email',
        ]);

        try {
            // Guardar entrevista
            Usr_part_curri_entrevistafun::updateOrCreate(
                [
                    'id_curri' => $request->id_curri,
                    'id_ofl' => $request->id_ofl,
                    'id_part' => $request->id_part,
                    'email_entrevistador' => auth()->user()->email,
                ],
                [
                    'id_terna' => $request->id_terna,                    
                    'lugar_entrevista' => $request->lugar_entrevista,
                    'observaciones' => $request->observaciones,
                ]
            );

            // Obtener datos del entrevistador
            $entrevistador = DB::table('m_empleados as m')
                ->leftJoin('posiciones as p', 'm.id_posicion', '=', 'p.id')
                ->where('m.email', auth()->user()->email)
                ->select(
                    DB::raw("CONCAT(
                        UPPER(LEFT(m.prinombre, 1)), LOWER(SUBSTRING(m.prinombre, 2)),
                        ' ',
                        UPPER(LEFT(m.priapellido, 1)), LOWER(SUBSTRING(m.priapellido, 2))
                    ) AS nombre_completo"),
                    'm.email',
                    'p.descpue as nom_puesto'
                )
                ->first();

            // Fallback por si no se encuentra el entrevistador
            if (!$entrevistador) {
                $entrevistador = (object)[
                    'nombre_completo' => 'Entrevistador no identificado',
                    'email' => auth()->user()->email,
                    'nom_puesto' => 'N/D'
                ];
            }

            // Formatear fecha
            $fecha_formateada = Carbon::parse($request->fecha_entrevista)->format('d-m-Y');

            // Preparar contenido del correo
            $mensaje = "
                <p>Se ha programado una entrevista con el candidato: <strong>{$request->candidato}</strong></p>
                <p><strong>Posición:</strong> {$request->nom_posicion}<br>
                <strong>Unidad:</strong> {$request->nom_unidad}<br>

                
                <strong>Lugar:</strong> {$request->lugar_entrevista}<br>
                <strong>Observaciones:</strong> {$request->observaciones}</p>
                <p><strong>Entrevistador:</strong> {$entrevistador->nombre_completo} ({$entrevistador->nom_puesto})<br>
                <strong>Email:</strong> {$entrevistador->email}</p>
            ";

            $asunto = 'Entrevista Programada - FOCUSTalent - ' . strip_tags($request->nom_posicion);

            // Enviar correo
            Mail::html($mensaje, function ($message) use ($request, $asunto) {
                $message->to($request->email_reclutador)
                        ->subject($asunto);
            });

            // Actualizar etapa de los participantes
            // 6: Entrevista Programada
            // 11: Descartado

            $nuevo_id_etapa = 6;
            $participantes = usr_participantes::where('id_ofl', $request->id_ofl)
                ->where('id_part_curriculum', $request->id_curri)
                ->get();

            foreach ($participantes as $participante) {
                if (($participante->id_etapa < $nuevo_id_etapa)||($participante->id_etapa == 11)) {
                    $participante->id_etapa = $nuevo_id_etapa;
                    $participante->motivo_descarte = null; // Limpiar motivo de descarte si lo había
                    $participante->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Entrevista programada correctamente y notificación enviada.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la entrevista',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verEntrevista(Request $request)
    {
        $id_ofl = $request->input('id_ofl');
        $id_curri = $request->input('id_curri');
        $id_part = $request->input('id_part');

        $entrevista = DB::table('usr_part_curri_entrevistafun')
        ->select(
            '*',
            DB::raw("DATE_FORMAT(fecha, '%Y-%m-%d') as fecha_entrevista")
        )
        ->where('id_curri', $id_curri)
        ->where('id_ofl', $id_ofl)
        ->where('id_part', $id_part)
        ->first();

        if (!$entrevista) {
            return response()->json(['success' => false, 'message' => 'Entrevista no encontrada']);
        }

        return response()->json(['success' => true, 'entrevista' => $entrevista]);
    }

    // Método para declinar candidato

    public function declinarCandidato(Request $request)
    {
        $request->validate([
            'id_part' => 'required|integer',
            'id_curri' => 'required|integer',
            'id_ofl' => 'required|integer',
            'obs_declinar' => 'required|string',
            'email_reclutador' => 'required|email',
            'candidato' => 'required|string',
            'nom_posicion' => 'required|string',
            'nom_unidad' => 'required|string',
        ]);

        try {
            // Verificar si había entrevista funcional registrada
            $entrevistaExistente = Usr_part_curri_entrevistafun::where('id_part', $request->id_part)
                ->where('id_curri', $request->id_curri)
                ->where('id_ofl', $request->id_ofl)
                ->first();

            // Eliminar la entrevista funcional si existía
            if ($entrevistaExistente) {
                $entrevistaExistente->delete();
            }

            // Actualizar estado del candidato y motivo de descarte
            usr_participantes::where('id', $request->id_part)
                ->where('id_part_curriculum', $request->id_curri)
                ->update([
                    'id_etapa' => 11,
                    'motivo_descarte' => $request->obs_declinar
                ]);

            // Obtener info del usuario que declina
            $declinador = DB::table('m_empleados as m')
                ->leftJoin('posiciones as p', 'm.id_posicion', '=', 'p.id')
                ->where('m.email', auth()->user()->email)
                ->select(
                    DB::raw("CONCAT(
                        UPPER(LEFT(m.prinombre, 1)), LOWER(SUBSTRING(m.prinombre, 2)),
                        ' ',
                        UPPER(LEFT(m.priapellido, 1)), LOWER(SUBSTRING(m.priapellido, 2))
                    ) AS nombre_completo"),
                    'm.email',
                    'p.descpue as nom_puesto'
                )
                ->first();

            // Mensaje base
            $mensaje = "
                <p>El candidato <strong>{$request->candidato}</strong> ha sido <strong>declinado</strong> del proceso de selección.</p>
                <p>
                    <strong>Posición:</strong> {$request->nom_posicion}<br>
                    <strong>Unidad:</strong> {$request->nom_unidad}<br>
                    <strong>Motivo:</strong> {$request->obs_declinar}
                </p>";

            // Añadir nota si tenía entrevista funcional
            if ($entrevistaExistente) {
                $mensaje .= "<p><strong>Nota:</strong> El candidato tenía una entrevista funcional programada, la cual fue eliminada.</p>";
            }

            // Datos de quien declina
            $mensaje .= "
                <p>
                    <strong>Declinado por:</strong> {$declinador->nombre_completo} ({$declinador->nom_puesto})<br>
                    <strong>Email:</strong> {$declinador->email}
                </p>";

            $asunto = "Candidato declinado - FOCUSTalent - " . strip_tags($request->nom_posicion);

            // Enviar correo
            Mail::html($mensaje, function ($message) use ($request, $asunto) {
                $message->to($request->email_reclutador)
                        ->subject($asunto);
            });

            return response()->json(['success' => true, 'message' => 'El candidato ha sido declinado y se notificó al reclutador.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al declinar candidato',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function verDeclinacion(Request $request)
    {
        $id_ofl = $request->input('id_ofl');
        $id_curri = $request->input('id_curri');
        $id_part = $request->input('id_part');

        $declinacion = DB::table('usr_participantes')
            ->select('motivo_descarte')
            ->where('id', $id_part)
            ->where('id_part_curriculum', $id_curri)
            ->where('id_ofl', $id_ofl)
            ->first();

        if (!$declinacion) {
            return response()->json(['success' => false, 'message' => 'Declinación no encontrada']);
        }

        return response()->json(['success' => true, 'declinacion' => $declinacion]);   
    }
    
}
