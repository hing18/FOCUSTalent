<?php

namespace App\Http\Controllers\re;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\re\Ofertas;
use App\Models\re\Curri_val_referencias;
use App\Models\re\Curri_prueba_psico;
use App\Models\re\Curri_docattach;
use App\Models\re\Usr_part_curri_entrevistafun;
use App\Models\re\Usr_parti_dependientes;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Mail\ContactanosMailable;
use App\Mail\EntrevistaFuncionalMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Re\PruebaApl;
use App\Models\Re\PruebaDisc;
use App\Models\Re\PruebaRazi;
use App\Models\Re\PruebaVeritas;
use App\Models\re\TernaCandidatos;
use App\Models\re\TernaEnviada;
use App\Models\re\Usr_part_contactos;
use App\Models\re\usr_part_curri_docattach;
use App\Models\re\usr_part_curriculum;
use App\Models\re\usr_part_obs_terna;
use App\Models\re\Usr_parti_contactos;
use App\Models\re\usr_partici_cartabeneficios;
use App\Models\re\Usr_partici_cartaofl;
use App\Models\re\Usr_partici_list_beneficios;
use App\Models\re\usr_participantes;
use App\Models\re\UsrPartCurriEntrevistaini;
use App\Models\re\VacanteSolicitud;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use NumberFormatter;

class OfertasController extends Controller
{
    public function index()
    {
        $id_menu = 15;
        $id_menu_sup = 2;

        if (!Auth::check()) {
            return view('auth.login');
        }

        $user = Auth::user();

        // Consulta principal (vacantes)
        $query = VacanteSolicitud::select(
            'vacantes_solicitudes.id',
            DB::raw("DATE_FORMAT(vacantes_solicitudes.created_at, '%d/%m/%Y') as fecha_sol"),
            DB::raw("DATE_FORMAT(vacantes_solicitudes.hasta, '%d/%m/%Y') as fecha_tope"),
            'est.nameund as unidad_economica',
            'estsec.nameund as seccion',
            'vacantes_solicitudes.id_puesto',
            'pos.descpue',
            'vacantes_solicitudes.cantidad',
            'vacantes_solicitudes.proceso',
            'vacantes_solicitudes.contratados',
            'vacantes_solicitudes.id_estatus',
            'sta.estatus',
            'sta.icono',
            'usr.name',
            'vacantes_solicitudes.confidencial',
            'vacantes_solicitudes.reclutador_asignado as id_reclutador_asignado',
            'm_rec.prinombre as prinombre_reclutador',
            'm_rec.priapellido as priapellido_reclutador',
            'm_rec.foto as reclutador_foto',
            'm_rec.color_text as color_text_reclutador',
            'm_rec.color_bg as color_bg_reclutador',
            DB::raw("COALESCE(etapas.incial, 0) AS incial"),
            DB::raw("COALESCE(etapas.funcional, 0) AS funcional"),
            DB::raw("COALESCE(etapas.ofertalaboral, 0) AS ofertalaboral"),
            DB::raw("COALESCE(etapas.documentacion, 0) AS documentacion"),
            DB::raw("COALESCE(etapas.firma, 0) AS firma"),
            DB::raw("COALESCE(etapas.contratado, 0) AS contratado"))
        ->leftJoin('posiciones as pos', 'vacantes_solicitudes.id_puesto', '=', 'pos.id')
        ->leftJoin('estructuras as est', 'est.id', '=', 'vacantes_solicitudes.id_ue')
        ->leftJoin('estructuras as estsec', 'estsec.id', '=', 'vacantes_solicitudes.id_secc')
        ->leftJoin('vacantes_estatus as sta', 'sta.id', '=', 'vacantes_solicitudes.id_estatus')
        ->leftJoin('users as usr', 'usr.id', '=', 'vacantes_solicitudes.id_user_solicitante')
        ->leftJoin('users as usr_rec', 'usr_rec.id', '=', 'vacantes_solicitudes.reclutador_asignado')
        ->leftJoin('m_empleados as m_rec', 'm_rec.id', '=', 'usr_rec.codigo')
        ->leftJoin(DB::raw('(SELECT 
                                id_ofl,
                                SUM(CASE WHEN id_etapa IN (1,2,3,4) THEN 1 ELSE 0 END) AS incial,
                                SUM(CASE WHEN id_etapa = 5 THEN 1 ELSE 0 END) AS funcional,
                                SUM(CASE WHEN id_etapa = 6 THEN 1 ELSE 0 END) AS ofertalaboral,
                                SUM(CASE WHEN id_etapa IN (7,8) THEN 1 ELSE 0 END) AS documentacion,
                                SUM(CASE WHEN id_etapa = 9 THEN 1 ELSE 0 END) AS firma,
                                SUM(CASE WHEN id_etapa = 10 THEN 1 ELSE 0 END) AS contratado
                            FROM usr_participantes
                            GROUP BY id_ofl
                        ) as etapas'), 'etapas.id_ofl', '=', 'vacantes_solicitudes.id')
        ->where('vacantes_solicitudes.id_estatus', '<=', 3);

        // Filtro confidencial
        if ($user->rol != 1) {
            $query->where(function($q) use ($user) {
                $q->where('vacantes_solicitudes.confidencial', 0)
                ->orWhere(function($q2) use ($user) {
                    $q2->where('vacantes_solicitudes.confidencial', 1)
                        ->where('vacantes_solicitudes.reclutador_asignado', $user->id);
                });
            });
        }

        // Ejecutar consulta (usar paginate si hay muchos registros)
        $data_ofertas = $query->get();

        // Cargar listas secundarias
        $data_vacstatus = DB::table('vacantes_estatus')
            ->select('id', 'estatus', 'icono')
            ->whereNotIn('id', [3, 5])
            ->orderBy('id')
            ->get();

        $data_partici_etapas_proceso = DB::table('usr_partici_etapas_proceso')
            ->select('id', 'nometapa', 'orden')
            ->orderBy('orden')
            ->get();

        $data_tipo_parentesco = DB::table('usr_tipo_parentesco')->select('id', 'parentesco')->get();
        $data_areas = DB::table('carreras_area')->orderBy('area')->get();
        $data_pagadoras = DB::table('colab_planillera_ceco')
            ->select('COD_PAGADORA', 'PAGADORA')
            ->groupBy('COD_PAGADORA', 'PAGADORA')
            ->orderBy('COD_PAGADORA')
            ->get();

        $data_firmantes = DB::table('users as u')
            ->select('u.id', 'm.prinombre', 'm.priapellido', 'p.descpue as cargo')
            ->leftJoin('m_empleados as m', 'm.id', '=', 'u.codigo')
            ->leftJoin('posiciones as p', 'p.id', '=', 'm.id_posicion')
            ->where('u.estatus', 1)
            ->where('u.firma_cartaoferta', 1)
            ->get();

        // Transformar nombres
        $formatearNombre = function ($nombre) {
            $excepciones = ['de', 'del', 'la', 'las', 'los', 'y'];
            $partes = explode(' ', strtolower($nombre));
            return implode(' ', array_map(fn($palabra) =>
                in_array($palabra, $excepciones) ? $palabra : ucfirst($palabra), $partes
            ));
        };

        $data_firmantes->transform(function ($item) use ($formatearNombre) {
            $item->nombre = $formatearNombre($item->prinombre . ' ' . $item->priapellido);
            unset($item->prinombre, $item->priapellido);
            return $item;
        });

        $data_ofertas->transform(function ($item) use ($formatearNombre) {
            $item->reclutador = $formatearNombre($item->reclutador);
            $item->name = $formatearNombre($item->name);
            return $item;
        });
 
        $data_reclutadores = User::select(
            'users.id',
            'm_empleados.prinombre',
            'm_empleados.priapellido',
            'm_empleados.foto',
            'm_empleados.color_text',
            'm_empleados.color_bg',
            DB::raw('COUNT(vacantes_solicitudes.id) AS total_vacantes')
        )
        ->join('usr_rol', 'usr_rol.id_usr', '=', 'users.id')
        ->join('m_empleados', 'users.codigo', '=', 'm_empleados.id')
        ->leftJoin('vacantes_solicitudes', function ($join) {
            $join->on('vacantes_solicitudes.reclutador_asignado', '=', 'users.id')
                ->where('vacantes_solicitudes.id_estatus', '<', 3);
        })
        ->whereIn('usr_rol.id_rol', [1, 4])
        ->where('users.estatus', 1)
        ->groupBy('users.id', 'm_empleados.prinombre', 'm_empleados.priapellido', 'm_empleados.foto', 'm_empleados.color_text', 'm_empleados.color_bg')
        ->get()
        ->transform(function ($item) use ($formatearNombre) {
            $item->nombre = $formatearNombre($item->prinombre . ' ' . $item->priapellido);
            return $item;
        });

        $data_beneficios = Usr_partici_list_beneficios::where('estatus', 1)
            ->where('tipo', 'b')
            ->orderBy('orden')
            ->get();

        $data_herramientas = Usr_partici_list_beneficios::where('estatus', 1)
            ->where('tipo', 'h')
            ->orderBy('orden')
            ->get();
        
        $stats = $this->getStats();

        // Renderizar vista
        return view('re.ofertas', compact(
            'id_menu', 'id_menu_sup', 'data_ofertas', 'data_vacstatus',
            'data_partici_etapas_proceso', 'data_firmantes', 'data_reclutadores',
            'data_tipo_parentesco', 'data_areas', 'data_pagadoras',
            'data_beneficios', 'data_herramientas','stats'
        ));
    }


    public function reasignarReclutador(Request $request)
    {
        // Validación
        $request->validate([
            'id_ofl' => 'required|integer|exists:vacantes_solicitudes,id',
            'id_reclutador' => 'required|integer|exists:users,id',
        ]);

        try {
            $id_ofl = $request->id_ofl;
            $id_reclutador = $request->id_reclutador;

            // Actualizar la vacante
            $oferta = VacanteSolicitud::findOrFail($id_ofl);
            $oferta->reclutador_asignado = $id_reclutador;
            $oferta->save();

            // Obtener datos del reclutador
            $reclutador = User::select('users.email', 'm_empleados.prinombre', 'm_empleados.priapellido', 'm_empleados.foto', 'm_empleados.color_text', 'm_empleados.color_bg')
                ->join('m_empleados', 'users.codigo', '=', 'm_empleados.id')
                ->where('users.id', $id_reclutador)
                ->first();

            // Enviar notificación si tiene email
            if ($reclutador && $reclutador->email) {
                    $data = [
                    'subject' => 'Asignación de Reclutador',
                    'body'    => "Has sido asignado como reclutador para la oferta laboral ID: $id_ofl.",
                    'html'    => '<p>Estimado/a '.$reclutador->prinombre.' '.$reclutador->priapellido.',</p>
                                <p>Se le informa que ha sido asignado como reclutador para la oferta laboral #: <strong>'.$id_ofl.'</strong>.</p>
                                <p>Favor revisar la plataforma para más detalles.</p>
                                <p>Saludos,</p>
                                <p>El equipo de FOCUSTalent</p>',
                ];
                Mail::to($reclutador->email)->send(new ContactanosMailable($data));
            }
                
            $data_reclutadores = User::select(
                'users.id',
                DB::raw('COUNT(vacantes_solicitudes.id) AS total_vacantes')
                )
                ->join('usr_rol', 'usr_rol.id_usr', '=', 'users.id')
                ->join('m_empleados', 'users.codigo', '=', 'm_empleados.id')
                ->leftJoin('vacantes_solicitudes', function ($join) {
                    $join->on('vacantes_solicitudes.reclutador_asignado', '=', 'users.id')
                        ->where('vacantes_solicitudes.id_estatus', '<', 3);
                })
                ->whereIn('usr_rol.id_rol', [1, 4])
                ->where('users.estatus', 1)
                ->groupBy('users.id')
                ->get();
            
            $stats = $this->getStats();
            return response()->json([
                'success' => true,
                'reclutador' => $reclutador,
                'reclutadores' => $data_reclutadores,
                'stats' => $stats,
                'message' => 'Reclutador reasignado correctamente y notificado por correo.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reasignar el reclutador: '.$e->getMessage()
            ], 500);
        }
    }


    public function ceco(Request $request)
    {
        $codcia = $request->input('codcia'); // Limpio y claro
        $data_cecos = DB::select("
            SELECT cod_cia, nom_cia 
            FROM colab_planillera_ceco 
            WHERE COD_PAGADORA = ? 
            ORDER BY cod_cia", 
            [$codcia]
        );

        return response()->json($data_cecos);
    }
    
    public function findcandidate(Request $request)
    {
        $data = $request->except('_token');
        $ids = $data['ids'] ?? '';
        $opt = $data['opt'] ?? null;
        $id_ofl = $data['id_ofl'] ?? null;

        // Validar que id_ofl venga
        if (!$id_ofl) {
            return response()->json(['error' => 'Falta id de la oferta laboral'], 400);
        }

        // Normalizar la lista de ids o emails: separar por coma, eliminar espacios vacíos
        $ids = str_replace(';', ',', $ids);
        $f_ids = array_filter(array_map('trim', explode(',', $ids)));

        if (empty($f_ids)) {
            return response()->json(['error' => 'Lista de búsqueda inválida'], 400);
        }

        $data_listado = collect(); // colección vacía para resultados

        if ($opt == 1) {
            // Buscar por email
            $data_listado = DB::table('usr_part_curriculum as c')
                ->leftJoin(DB::raw('(
                    SELECT e1.*
                    FROM usr_part_educacion e1
                    INNER JOIN (
                        SELECT id_curri, MAX(ano) AS max_ano
                        FROM usr_part_educacion
                        GROUP BY id_curri
                    ) e2 ON e1.id_curri = e2.id_curri AND e1.ano = e2.max_ano
                ) as e'), 'c.id', '=', 'e.id_curri')
                ->leftJoin('usr_estatus_educ as s', 'e.estatuseduc', '=', 's.id')
                ->whereNotIn('c.id', function ($query) use ($id_ofl) {
                    $query->select('id_part_curriculum')
                        ->from('usr_participantes')
                        ->where('id_ofl', $id_ofl);
                })
                ->whereIn('c.email', $f_ids)
                ->where(function ($query) {
                    $query->where('c.estado_registro', 0)
                        ->orWhereNull('c.estado_registro');
                })
                ->select(
                    'c.id',
                    'c.prinombre',
                    'c.priapellido',
                    'c.email',
                    'c.tel',
                    'c.cv_doc as cv',
                    DB::raw("IF(c.foto IS NULL, IF(c.genero = 'M', 'storage/fotos/el.png', 'storage/fotos/ella.png'), c.foto) AS foto_mostrar"),
                    'e.entidad',
                    'e.titulo',
                    's.estatuseduc'
                )
                ->distinct()
                ->get();

        } else {
            // Buscar por área de experiencia
            $data_listado = DB::table('usr_part_curriculum as c')
                ->leftJoin(DB::raw('(
                    SELECT e1.*
                    FROM usr_part_educacion e1
                    INNER JOIN (
                        SELECT id_curri, MAX(ano) AS max_ano
                        FROM usr_part_educacion
                        GROUP BY id_curri
                    ) e2 ON e1.id_curri = e2.id_curri AND e1.ano = e2.max_ano
                ) as e'), 'c.id', '=', 'e.id_curri')
                ->leftJoin('usr_estatus_educ as s', 'e.estatuseduc', '=', 's.id')
                ->whereNotIn('c.id', function ($query) use ($id_ofl) {
                    $query->select('id_part_curriculum')
                        ->from('usr_participantes')
                        ->where('id_ofl', $id_ofl);
                })
                ->whereIn('c.id', function ($query) use ($f_ids) {
                    $query->select('ex.id_curri')
                        ->from('usr_part_experiencia_laboral as ex')
                        ->whereIn('ex.id_subarea', function ($q) use ($f_ids) {
                            $q->select('id')
                                ->from('carreras_subarea')
                                ->whereIn('id_area', $f_ids);
                        })
                        ->groupBy('ex.id_curri');
                })
                ->where(function ($query) {
                    $query->where('c.estado_registro', 0)
                        ->orWhereNull('c.estado_registro');
                })
                ->select(
                    'c.id',
                    'c.prinombre',
                    'c.priapellido',
                    'c.email',
                    'c.tel',
                    'c.cv_doc as cv',
                    DB::raw("IF(c.foto IS NULL, IF(c.genero = 'M', 'storage/fotos/el.png', 'storage/fotos/ella.png'), c.foto) AS foto_mostrar"),
                    'e.entidad',
                    'e.titulo',
                    's.estatuseduc'
                )
                ->distinct()
                ->get();
        }

        // Obtener IDs de candidatos para buscar procesos
        $idsCandidatos = $data_listado->pluck('id')->toArray();

        $data_procesos = collect();
        if (!empty($idsCandidatos)) {
            $data_procesos = DB::table('usr_participantes as c')
                ->join('vacantes_solicitudes as v', function ($join) {
                    $join->on('v.id', '=', 'c.id_ofl')
                        ->where('v.id_estatus', '<', 4);
                })
                ->leftJoin('posiciones as p', 'p.id', '=', 'v.id_puesto')
                ->leftJoin('estructuras as e', 'e.id', '=', 'v.id_ue')
                ->leftJoin('usr_part_curriculum as curri', function ($join) {
                    $join->on('c.id_part_curriculum', '=', 'curri.id')
                        ->where('curri.estado_registro', '<>', 1);
                })
                ->where('c.id_etapa', '<', 7)
                ->whereIn('c.id_part_curriculum', $idsCandidatos)
                ->select(
                    'c.id_part_curriculum as id_curri',
                    'c.id_ofl',
                    'p.descpue as puesto',
                    'e.nameund as unidad'
                )
                ->get();
        }

        $data_experiencia = collect();
        if (!empty($idsCandidatos)) {
            if ($opt == 1) {
                $data_experiencia = DB::table('usr_part_experiencia_laboral as ex')
                    ->join('usr_part_curriculum as c', 'ex.id_curri', '=', 'c.id')
                    ->whereIn('c.id', $idsCandidatos)
                    ->select(
                        'ex.id as idex',
                        'c.id',
                        'ex.id_curri',
                        'ex.id_subarea',
                        'ex.subarea'
                    )
                    ->get();
            } else {
                $data_experiencia = DB::table('usr_part_experiencia_laboral as ex')
                    ->join('usr_part_curriculum as c', 'ex.id_curri', '=', 'c.id')
                    ->whereIn('c.id', $idsCandidatos)
                    ->whereIn('ex.id_subarea', function ($query) use ($f_ids) {
                        $query->select('id')
                            ->from('carreras_subarea')
                            ->whereIn('id_area', $f_ids);
                    })
                    ->select(
                        'ex.id as idex',
                        'c.id',
                        'ex.id_curri',
                        'ex.id_subarea',
                        'ex.subarea'
                    )
                    ->get();
            }
        }

        return response()->json([
            'candidatos' => $data_listado,
            'procesos' => $data_procesos,
            'experiencias' => $data_experiencia,
        ]);
    }

    public function listar_candidate_terna(Request $request)
    {
        $id_ofl = $request->input('id_ofl');
        if (!$id_ofl) {
            return response()->json(['success' => false, 'message' => 'ID de oferta laboral requerido.'], 400);
        }

        // Consulta Participantes con CTEs
            $lista_id_curri = usr_participantes::whereBetween('id_etapa', [4, 6])
                ->where('id_ofl', $id_ofl)
                ->pluck('id_part_curriculum'); // Devuelve una colección con los IDs

            $idsCurris = $lista_id_curri->toArray();
                if (empty($idsCurris)) {
                    return response()->json(['success' => false, 'message' => 'No hay candidatos para presentar en la terna.']);
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
                    return response()->json(['success' => false, 'message' => 'Los candidatos no cuentan con la documentación completa para presentar en la terna.']);
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
                    ->selectRaw("
                        p.id as id_part,
                        curri.id as id_curri,
                        curri.foto,
                        curri.prinombre,
                        curri.priapellido,
                        curri.email,
                        curri.tel,
                        CONCAT(UPPER(LEFT(n.nacionalidad, 1)), LOWER(SUBSTRING(n.nacionalidad, 2))) AS nacionalidad,
                        curri.cv_doc,
                        obst.id as id_obst")
                    ->whereIn('curri.id', $idsCurris)  // Filtra los currículos por los ids que pasas en $idsCurris
                    ->where('p.id_ofl', $id_ofl)  // Filtra los participantes por el id_ofl específico
                    ->get();

                $idpart = $participantes->toArray();
                if (empty($idpart)) {
                    return response()->json(['success' => false, 'message' => 'No hay candidatos para presentar en la terna.']);
                }
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
            'participantes' => $participantes,
            'competencias' => $competencias,
            'ult_pruebas_apl' => $ult_result_apl,
            'resultados_competencias_apl' => $resultados_competencias_apl,
            'ult_pruebas_razi' => $ult_pruebas_razi,
            'ult_pruebas_disc' => $ult_pruebas_disc,
            'ult_pruebas_veritas' => $ult_pruebas_veritas
            
        ]);
    }

    public function msg_sendTerna(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado.'
            ], 401);
        }

        $data_users = DB::table('users as u')
            ->leftJoin('m_empleados as m', 'u.codigo', '=', 'm.id')
            ->leftJoin('posiciones as p', 'p.id', '=', 'm.id_posicion')
            ->where('u.id', $user->id)
            ->selectRaw("
                CONCAT(
                    UPPER(LEFT(m.prinombre, 1)), LOWER(SUBSTRING(m.prinombre, 2)), ' ',
                    UPPER(LEFT(m.priapellido, 1)), LOWER(SUBSTRING(m.priapellido, 2))
                ) AS nombre_completo,
                m.email,
                CONCAT(UPPER(LEFT(p.descpue, 1)), LOWER(SUBSTRING(p.descpue, 2))) AS nom_puesto
                
            ")
            ->first();

        $msg_sendterna = DB::table('usr_part_msg_send')
            ->select('msg')
            ->where('tipo','=','terna')
            ->get();

        return response()->json([
            'success' => true,
            'data_users' => $data_users,
            'msg_sendterna' => $msg_sendterna
        ]);
    }

    public function sendTerna(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'send_OBSterna' => 'required|string',
            'subject' => 'required|string',
        ]);

        $to = $request->input('to');
        $messageBody = $request->input('send_OBSterna');
        $subject = $request->input('subject');
        $idOferta = $request->input('id_ofl');
        $seleccionados = $request->input('terna', []);

        // Enviar correo
        Mail::html($messageBody, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });

        // Actualizar etapa de los participantes seleccionados
        $nuevo_id_etapa = 5;

        $participantes = usr_participantes::where('id_ofl', $idOferta)
            ->whereIn('id_part_curriculum', $seleccionados)
            ->get();

        foreach ($participantes as $participante) {
            if ($participante->id_etapa < $nuevo_id_etapa) {
                $participante->id_etapa = $nuevo_id_etapa;
                $participante->save();
            }
        }

        // Registrar terna enviada
        TernaEnviada::create([
            'oferta_id' => $idOferta,
            'candidatos' => $seleccionados,
            'email_destino' => $to,
            'email_reclutador' => Auth::user()->email,
        ]);

        // Registrar terna enviada
        // Registrar candidatos de la terna (uno por uno)
        foreach ($seleccionados as $id_curri) {
            TernaCandidatos::firstOrCreate([
                'id_ofl' => $idOferta,
                'id_curri' => $id_curri,
                'email_entrevistador' => Auth::user()->email,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function editOBSTerna(Request $request)
    {
        $id_curri = $request->input('id_curri');
        $id_ofl = $request->input('id_ofl');

        $obsterna = usr_part_obs_terna::where('id_curri', $id_curri)
            ->where('id_ofl', $id_ofl)
            ->select('obs')
            ->first();

        return response()->json([
            'success' => true,
            'obsterna' => $obsterna?->obs ?? '',
        ]);
    }

    public function addOBSTerna(Request $request)
    {
        $request->validate([
            'id_part' => 'required|integer|exists:usr_participantes,id',
            'id_ofl' => 'required|integer',
            'id_curri' => 'required|integer',
            
        ]);

        $id_part = $request->input('id_part');
        $id_ofl = $request->input('id_ofl');
        $id_curri = $request->input('id_curri');
        $observacion = $request->input('OBSterna');

        // Actualiza si ya existe, o crea uno nuevo si no
        if($observacion!=null)
        {   
            usr_part_obs_terna::updateOrCreate(
            [                
                'id_part' => $id_part,
            ],
            [   'id_curri' => $id_curri,
                'id_ofl' => $id_ofl,
                'obs' => $observacion,
            ]
            );
        }
        else{
             DB::table('usr_part_obs_terna')
            ->where('id_part','=', $id_part)
            ->where('id_curri','=', $id_curri)
            ->where('id_ofl','=', $id_ofl)   
            ->delete();
        }

        return response()->json(['success' => true, 'message' => 'Observación guardada correctamente.', 'obsterna' => $observacion]);
    }

    public function agregarCandidatos(Request $request)
    {
        $request->validate([
            'id_oferta' => 'required|integer|exists:vacantes_solicitudes,id',
            'candidatos' => 'required|array',
            'candidatos.*' => 'integer|exists:usr_part_curriculum,id',
        ]);

        // Obtener información de la oferta
        $data_oferta = DB::table('vacantes_solicitudes as ofl')
            ->where('ofl.id', $request->id_oferta)
            ->select('ofl.id_jer', 'ofl.id_puesto')
            ->first();

        if (!$data_oferta) {
            return response()->json(['success' => false, 'message' => 'Oferta no encontrada.'], 404);
        }

        // Recorrer candidatos y agregarlos
        foreach ($request->candidatos as $id_curri) {
            DB::table('usr_participantes')->updateOrInsert(
                [
                    'id_ofl' => $request->id_oferta,
                    'id_part_curriculum' => $id_curri,
                    'id_jer' => $data_oferta->id_jer,
                    'id_puesto' => $data_oferta->id_puesto,
                ],
                [
                    'id_etapa' => 1,
                    'created_at' => now()
                ]
            );
        }

        return response()->json(['success' => true]);
    }
    
    // AGREGA ENTREVITAS
    public function fentrevist(Request $request)
    {   if (isset(Auth::user()->id)) 
        {  $data= request()->except('_token');
            $sel_entrevistador= $data['sel_entrevistador'];
            $id_curri= $data['id_curri']; 
            $id_participante= $data['id_participante'];
            $sel_fecha= $data['sel_fecha'];
            $sel_hora= $data['sel_hora'];
            $paso= $data['paso'];
            $data_users_entrevistas= DB::select("SELECT id,name as nombre ,puesto,email as mail FROM users where id=$sel_entrevistador");
            
            foreach ($data_users_entrevistas as $r)
                {   $id=$r->id;
                    $nombre=$r->nombre;
                    $puesto=$r->puesto;
                    $mail=$r->mail;
                }
 
                $new= new Usr_part_curri_entrevistafun();
                $new->id_curri= $id_curri;
                $new->id_participante= $id_participante;
                $new->nom_entrevistador= $nombre;
                $new->email= $mail;
                $new->puesto= $puesto;
                $new->fecha= $sel_fecha;
                $new->hora= $sel_hora;
                $new->save();

                $data_entrevistas= DB::select("SELECT id FROM usr_part_curri_entrevistafun where id_curri=$id_curri and id_participante=$id_participante");            
                foreach ($data_entrevistas as $r)
                {   $id_entrevista=$r->id;}
                
                DB::table('usr_participantes')
                ->where('id','=', $id_participante)
                ->update(['id_etapa' => $paso]);
    
                $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");
    
                foreach ($query_part as $res)
                {   $banges=$res->banges;}

                $salidaJson=array(
                    "id"=>$id,
                    "nombre"=>$nombre,
                    "puesto"=>$puesto,
                    "mail"=>$mail,
                    "id_entrevista"=>$id_entrevista,
                    "banges"=>$banges,
                );
            echo(json_encode($salidaJson));    
        }
        else{   return view('auth.login');}  
    }

    // AGREGA DEPENDIENTES
    public function dependientes(Request $request)
    {   if (isset(Auth::user()->id)) 
        {
            $data= request()->except('_token');
            $nombre_dependiente= $data['nombre_dependiente'];
            $sel_parentesco= $data['sel_parentesco'];
            $fech_nac_dependiente= $data['fech_nac_dependiente'];
            $id_curri= $data['id_curri'];

            $query_parentesco= DB::select("SELECT parentesco FROM usr_tipo_parentesco where id=$sel_parentesco");            
            foreach ($query_parentesco as $r)
            {   $parentesco=$r->parentesco; }

            $new= new Usr_parti_dependientes();
            $new->id_part_curriculum= $id_curri;
            $new->nombre= $nombre_dependiente;
            $new->parentesco= $parentesco;
            $new->f_nacimiento= $fech_nac_dependiente;
            $new->save();

            $query_parentesco= DB::select("SELECT id,id_part_curriculum,nombre,parentesco,f_nacimiento  FROM usr_part_dependientes where id_part_curriculum=$id_curri");            

            echo(json_encode($query_parentesco));    
        }
        else{   return view('auth.login');}
    }

    // AGREGA CONTACTOS DE URGENCIA
    public function contactos(Request $request)
    {   if (isset(Auth::user()->id)) 
            {
                $data= request()->except('_token');
                $nombre_contacto= $data['nombre_contacto'];
                $tel_contacto= $data['tel_contacto'];
                $id_curri= $data['id_curri'];
    
    
                $new= new Usr_part_contactos();
                $new->id_part_curriculum= $id_curri;
                $new->nombre= $nombre_contacto;
                $new->contacto= $tel_contacto;
                $new->save();
    
                $query_contactos= DB::select("SELECT id,nombre,contacto  FROM usr_part_contactos where id_part_curriculum=$id_curri");            
    
                echo(json_encode($query_contactos));    
            }
            else{   return view('auth.login');}
    }
    
    // DESCARTE DE CANDIDATO
    public function descarte(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri=$data['id_curri']; 
            $id_participante= $data['id_participante']; 
            $encuenta= $data['encuenta']; 
            $txt_area_descarte= $data['txt_area_descarte']; 
            
            DB::table('usr_participantes')->where('id','=', $id_participante ) ->update(['id_etapa' => 8,'motivo_descarte'=>$txt_area_descarte]);
            $query_part = DB::select("SELECT  partici_status.banges as banges, partici.id_ofl id_ofl
            FROM usr_participantes AS partici 
            LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
            WHERE partici.id_part_curriculum=$id_curri");
            foreach ($query_part as $res)
            {   $banges=$res->banges;
                $id_ofl=$res->id_ofl;}      

            if($encuenta==1)
            {   DB::table('usr_part_curriculum')->where('id','=', $id_curri ) ->update(['estado_registro' => 2,'motivo_descarte'=>$txt_area_descarte]);}

            $cant_inicial=0; $cant_funcional=0; $cant_ofertalaboral=0; $cant_documentacion=0; $cant_firma=0; $cant_contratado=0; $cant_proceso=0;
            $query = DB::select("SELECT id_etapa, count(1)  as cant FROM usr_participantes                 
            WHERE id_ofl=$id_ofl group by id_etapa");
            foreach ($query as $res)
            {   
                if($res->id_etapa==1 || $res->id_etapa==2)
                {   $cant_inicial= $cant_inicial + $res->cant;}
                if($res->id_etapa==3)
                {   $cant_funcional= $cant_funcional + $res->cant;}
                if($res->id_etapa==4)
                {   $cant_ofertalaboral= $cant_ofertalaboral + $res->cant;}
                if($res->id_etapa==5)
                {   $cant_documentacion= $cant_documentacion + $res->cant;}
                if($res->id_etapa==6)
                {   $cant_firma= $cant_firma + $res->cant;}
                if($res->id_etapa==7)
                {   $cant_contratado= $cant_contratado + $res->cant;}
            }
            // cantidad en proceso NO cuenta los contratador y eliminados
            $cant_proceso= $cant_inicial + $cant_funcional + $cant_ofertalaboral + $cant_documentacion + $cant_firma;            
            DB::table('vacantes_solicitudes')->where('id','=', $id_ofl)->update(['proceso' => $cant_proceso, 'contratados' => $cant_contratado ]);

            $salidaJson=array(
                "banges"=>$banges,
                "cant_proceso"=>$cant_proceso,
                "cant_inicial"=>$cant_inicial,
                "cant_funcional"=>$cant_funcional,
                "cant_ofertalaboral"=>$cant_ofertalaboral,
                "cant_documentacion"=>$cant_documentacion,
                "cant_firma"=>$cant_firma,
                "cant_contratado"=>$cant_contratado,
                "id_ofl"=>$id_ofl,
            );

            echo(json_encode($salidaJson));
        }
        else{   return view('auth.login');}        
    }

    // AGREGA PRUEBAS PSICOLÓGICAS
    public function pruebaspsico(Request $request)
    {   
        if (isset(Auth::user()->id)) 
        {  $data= request()->except('_token');
           $id_curri=$data['id_curri']; 
           $id_participante= $data['id_participante']; 
           $sel_evaluacion_aplicada= $data['sel_evaluacion_aplicada'];
           $pruebapsico_resultado= $data['pruebapsico_resultado'];
           $f_envio_prueba= $data['f_envio_prueba'];
           $new= new Curri_prueba_psico();
           $new->id_curri= $id_curri;
           $new->prueba= $sel_evaluacion_aplicada;
           $new->resultado= $pruebapsico_resultado;
           $new->f_prueba= $f_envio_prueba;
           $new->id_participante= $id_participante;   
           $new->save();
           
            $data_prueba_psico= DB::select("SELECT pru_psico.id as id_prueba, pruebas.nom_prueba, pru_psico.f_prueba, pru_psico.resultado, resppruebas.respuesta
            FROM usr_part_curri_pru_psico pru_psico
            LEFT JOIN pruebaspsicoresp resppru_psico ON (resppru_psico.id = pru_psico.resultado) 
            LEFT JOIN pruebaspsicometricas pruebas ON (pruebas.id = pru_psico.prueba) 
            LEFT JOIN pruebaspsicoresp resppruebas ON (resppruebas.id = pru_psico.resultado) 

            WHERE pru_psico.id_participante=$id_participante");

            $salidaJson=array(  "prueba_psico"=>$data_prueba_psico,  );

            echo(json_encode($salidaJson));    
        }
        else{   return view('auth.login');}
    }

    //  ELIMINA REGISTRO DE PRUEBA PSICOMETRICA
    public function destroypruebapsico(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_curri'];
            $id_prueba= $data['id_prueba'];
            $resp=0;
            $paso=2;
            $banges="";
            
            $query_parentesco= DB::select("SELECT count(id) conteo FROM usr_part_curri_pru_psico where id_curri=$id_curri");  
            foreach ($query_parentesco as $r)
            {   $resp=$r->conteo;}

                if($resp>=1)
                { DB::table('usr_part_curri_pru_psico')->where('id_curri','=', $id_curri)->where('id','=', $id_prueba)->delete();}
                
                if($resp==1)
                {  DB::table('usr_participantes')->where('id_part_curriculum','=', $id_curri ) ->update(['id_etapa' => $paso]);
                    $query_part = DB::select("SELECT  partici_status.banges as banges
                    FROM usr_participantes AS partici 
                    LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                    WHERE partici.id_part_curriculum=$id_curri");
                    foreach ($query_part as $res)
                    {   $banges=$res->banges;}               
                 }
                 $salidaJson=array("banges"=>$banges,
                 "paso"=>$paso,
                 "resp"=>$resp,);
                 echo(json_encode($salidaJson));
            }
            else{   return view('auth.login');}
    }   

    //  ELIMINA CONTACTOS
    public function destroycontacto(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_curri'];
            $id_contacto= $data['id_contacto'];
            $resp=0;
            $paso=5;
            $i=0;
            $query_parentesco= DB::select("SELECT id  FROM usr_part_contactos where id_part_curriculum=$id_curri and id=$id_contacto");  
            foreach ($query_parentesco as $r)
            {   $resp=1;
                $i++; }
            if($resp==1)
            { DB::table('usr_part_contactos')->where('id_part_curriculum','=', $id_curri)->where('id','=', $id_contacto)->delete();}
            if($i==1)
            {  DB::table('usr_participantes')->where('id_part_curriculum','=', $id_curri ) ->update(['id_etapa' => $paso]);
                $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id_part_curriculum=$id_curri");
                foreach ($query_part as $res)
                {   $banges=$res->banges;}               
             }
             $salidaJson=array("banges"=>$banges,
             "paso"=>$paso,
             "resp"=>$resp,);
             echo(json_encode($salidaJson));
        }
        else{   return view('auth.login');}
    }

    //  ELIMINA DEPENDIENTES
    public function destroydepend(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_curri'];
            $id_depend= $data['id_depend'];
            $resp=0;
            $query_parentesco= DB::select("SELECT id,id_part_curriculum,nombre,parentesco,f_nacimiento  FROM usr_part_dependientes where id_part_curriculum=$id_curri and id=$id_depend");  
            foreach ($query_parentesco as $r)
            {   $resp=1; }
            if($resp==1)
            { DB::table('usr_part_dependientes')->where('id_part_curriculum','=', $id_curri)->where('id','=', $id_depend)->delete();}
            echo $resp;
            
        }
        else{   return view('auth.login');}
    }

    //  ELIMINA ENTREVISTA
    public function destroyentre(Request $request)
    {   if (isset(Auth::user()->id)) 
        {  $data= request()->except('_token');
            $id_entrevista= $data['id_entrevista'];
            $id_participante= $data['id_participante'];
            DB::table('usr_part_curri_entrevistafun')
            ->where('id','=', $id_entrevista)
            ->delete();

            $cant=1;
            $data_cant_entrevistas= DB::select("SELECT count(*) as cant FROM usr_part_curri_entrevistafun where id=$id_entrevista");            
            foreach ($data_cant_entrevistas as $r)
            {   $cant=$r->cant; }

            if($cant==0)
            {                     
                DB::table('usr_participantes')
                ->where('id','=', $id_participante)
                ->update(['id_etapa' => 3]);
            }

            $banges='-';
            $query_part = DB::select("SELECT  partici_status.banges as banges
            FROM usr_participantes AS partici 
            LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
            WHERE partici.id=$id_participante");
    
            foreach ($query_part as $res)
            {   $banges=$res->banges;}   
                $salidaJson=array("banges"=>$banges,"cant"=>$cant,);
            echo(json_encode($salidaJson));
  
        }
        else{   return view('auth.login');}  
    }

    
    // MUESTRA DETALLE DE LA OFERTA LABORAL EN ESTATUS INICIAL
    public function show(Ofertas $ofertas)
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $id_ofl = request('id_ofl');

        $query = VacanteSolicitud::selectRaw("
                vacantes_solicitudes.id,
                DATE_FORMAT(vacantes_solicitudes.created_at, '%d/%m/%Y') AS fecha_sol,
                est.nameund AS unidad_economica,
                estsec.nameund AS seccion,
                mot.motivo,
                vacantes_solicitudes.autorizacion,
                vacantes_solicitudes.comentarios,
                gen.genero,
                vacantes_solicitudes.rango_edad,
                pos.descpue,
                vacantes_solicitudes.cantidad,
                usr.name AS usrname,
                pos.aprobado,
                vacantes_solicitudes.confidencial,
                vacantes_solicitudes.min_salario,
                vacantes_solicitudes.max_salario,
                usr_reclu.name AS usrname_reclutador,
                vacantes_solicitudes.tiempocalculado,
                vacantes_solicitudes.id_estatus,
                vacantes_solicitudes.contratados,
                (
                    SELECT COUNT(0)
                    FROM colab_pl_rh HCR
                    WHERE (HCR.COD_PUESTO_RH = pos.codigo
                        AND TRIM(HCR.COD_UE) = TRIM(est.codigo))
                ) AS countreal
            ")
            ->leftJoin('posiciones AS pos', 'vacantes_solicitudes.id_puesto', '=', 'pos.id')
            ->leftJoin('estructuras AS est', 'est.id', '=', 'vacantes_solicitudes.id_ue')
            ->leftJoin('estructuras AS estsec', 'estsec.id', '=', 'vacantes_solicitudes.id_secc')
            ->leftJoin('vacantes_motivo AS mot', 'mot.id', '=', 'vacantes_solicitudes.id_motivo')
            ->leftJoin('vacantes_genero AS gen', 'gen.letra', '=', 'vacantes_solicitudes.genero')
            ->leftJoin('users AS usr', 'usr.id', '=', 'vacantes_solicitudes.id_user_solicitante')
            ->leftJoin('users AS usr_reclu', 'usr_reclu.id', '=', 'vacantes_solicitudes.reclutador_asignado')
            ->leftJoin('colab_planillera_ceco AS ceco', 'ceco.cod_cia', '=', 'vacantes_solicitudes.cod_cia')
            ->where('vacantes_solicitudes.id', $id_ofl)
            ->first();

        if (!$query) {
            return response()->json(['error' => 'Oferta no encontrada'], 404);
        }

        return response()->json($query);
    }

    // BUSCAR DITRITO Y CORREGIMIENTO
    public function finddistcor(Ofertas $ofertas)
    {   
        $data= request()->except('_token');
        $opt_find= $data['opt_find'];
        $sel= $data['sel'];  
        if($opt_find=='distrito')      
        {   $data= DB::select("SELECT id, distrito as lugar FROM dir_distritos where id_provincia=$sel order by distrito asc");}
        if($opt_find=='corregimiento')
        {   $data= DB::select("SELECT id, corregimiento as lugar FROM dir_corregimientos where id_distrito=$sel order by corregimiento asc");}

        
        echo(json_encode($data));
    }

    public function edit(Ofertas $ofertas)
    {   
        $data= request()->except('_token');
        $id_ofl= $data['id_ofl'];
            $data_pruebas = DB::table('usr_participantes as p')
                ->leftJoin('pruebas_razi as r', 'r.curriculum_id', '=', 'p.id_part_curriculum')
                ->leftJoin('pruebas_disc as d', 'd.curriculum_id', '=', 'p.id_part_curriculum')
                ->leftJoin('pruebas_apl as a', 'a.curriculum_id', '=', 'p.id_part_curriculum')
                ->leftJoin('pruebas_veritas as v', 'v.curriculum_id', '=', 'p.id_part_curriculum')

                // Subconsulta de última validación laboral
                ->leftJoin(DB::raw('(
                    SELECT id_curri, MAX(f_validacion) as f_validacion
                    FROM usr_part_experiencia_laboral
                    GROUP BY id_curri
                ) as rl'), 'rl.id_curri', '=', 'p.id_part_curriculum')

                // Subconsulta de última validación personal
                ->leftJoin(DB::raw('(
                    SELECT id_curri, MAX(f_validacion) as f_validacion
                    FROM usr_part_referencias_personales
                    GROUP BY id_curri
                ) as rp'), 'rp.id_curri', '=', 'p.id_part_curriculum')

                ->where('p.id_ofl', $id_ofl)

                ->select(
                    'p.id as id_participante',
                    'p.id_part_curriculum as id_curri',
                    'p.id_etapa',
                    'r.fecha_realizada as f_razi',
                    'd.fecha_realizada as f_disc',
                    'a.fecha_realizada as f_apl',
                    'v.fecha_realizada as f_veritas',
                    'rl.f_validacion as f_valida_ref_l',
                    'rp.f_validacion as f_valida_ref_p'
                )
                ->get();
            foreach ($data_pruebas as $participante) {
                if ($participante->f_razi !== null && $participante->f_disc !== null && $participante->f_apl !== null && $participante->f_veritas !== null && $participante->id_etapa < 2)
                { usr_participantes::where('id', $participante->id_participante)->update(['id_etapa' => 2]);}
                if ($participante->f_valida_ref_l !== null && $participante->f_valida_ref_p !== null && $participante->id_etapa < 2)
                { usr_participantes::where('id', $participante->id_participante)->update(['id_etapa' => 2]);}
            }

            $data_oferta = DB::select("
                SELECT 
                    v.created_at as f_solicitud,
                    DATE_FORMAT(v.created_at, '%d-%m-%Y') as f_solicitud_formateada,
                    v.contratados,
                    v.cantidad,
                    v.id_puesto,
                    p.descpue as nom_puesto,
                    v.id_secc as id_deptosuc,
                    e1.nameund as deptosuc,
                    v.id_ue,
                    e.nameund as unidad,
                    e.hrs_mensuales,
                    v.cantidad as cant_colicitados,
                    v.comentarios,
                    CONCAT(UPPER(LEFT(j.nombrejer, 1)), LOWER(SUBSTRING(j.nombrejer, 2))) as jerarquia
                FROM vacantes_solicitudes v
                LEFT JOIN posiciones p ON p.id = v.id_puesto
                LEFT JOIN estructuras e1 ON e1.id = p.iduni
                LEFT JOIN estructuras e ON e.id = p.idue
                LEFT JOIN descriptivos df ON df.id = p.iddf
                LEFT JOIN jerarquias j ON j.id = df.idjer
                WHERE v.id = ?
            ", [$id_ofl]);

            $data_candidatos = DB::table('vacantes_solicitudes as sol')
                ->leftJoin('usr_participantes as partici', 'partici.id_ofl', '=', 'sol.id')
                ->leftJoin('usr_part_curriculum as curri', 'curri.id', '=', 'partici.id_part_curriculum')
                ->leftJoin('usr_partici_etapas_proceso as partici_status', 'partici_status.id', '=', 'partici.id_etapa')
                
                ->leftJoin('usr_part_bitacora as bita', function($join) {
                    $join->on('bita.id_part', '=', 'partici.id')
                        ->on('bita.id_ofl', '=', 'partici.id_ofl')
                        ->on('bita.id_curri', '=', 'partici.id_part_curriculum')
                        ->on('bita.id_etapa', '=', 'partici.id_etapa');
                })

                ->leftJoin(DB::raw('
                    (
                        SELECT e1.*
                        FROM usr_part_educacion e1
                        INNER JOIN (
                            SELECT id_curri, MAX(ano) as max_ano
                            FROM usr_part_educacion
                            GROUP BY id_curri
                        ) e2 ON e1.id_curri = e2.id_curri AND e1.ano = e2.max_ano
                    ) as e
                '), 'curri.id', '=', 'e.id_curri')
                
                ->leftJoin('usr_nivel_educ as n', 'e.nivel_educ', '=', 'n.id')
                ->leftJoin('usr_estatus_educ as s', 'e.estatuseduc', '=', 's.id')
                ->where('sol.id', $id_ofl)
                ->orderBy('partici.created_at', 'desc')
                ->select([
                    'partici.id as id_participante',
                    'curri.prinombre',
                    'curri.priapellido',
                    'curri.tel',
                    'curri.email',
                    'curri.foto',
                    'partici_status.id as id_etapa',
                    'partici_status.banges',
                    DB::raw("IF(bita.created_at IS NULL, '', DATE_FORMAT(bita.created_at, '%d-%m-%Y')) as f_status"),
                    DB::raw("IF(partici.aspiracion_sal IS NULL, '-', FORMAT(partici.aspiracion_sal, 2)) as aspiracion_sal"),
                    'curri.id as id_curri',
                    'curri.color_text as color_text',
                    'curri.color_bg as color_bg',
                    'curri.cv_doc as cv',
                    'e.titulo',
                    'e.entidad',
                    DB::raw("CONCAT(UPPER(LEFT(s.estatuseduc, 1)), LOWER(SUBSTRING(s.estatuseduc, 2))) as estatuseduc"),

                ])
                ->get();

                $subQuery = DB::table('usr_part_curri_entrevistafun')
                    ->select('id_curri', 'notifica_contratar')
                    ->where('id_ofl', $id_ofl)
                    ->where('entrevista_realizada', true)
                    ->where('opcionesContratacion', 1);

                $subQuery1 = DB::table('usr_part_curri_entrevistafun')
                    ->select('id_curri', DB::raw('AVG(valoracion) as valoracion_promedio'))
                    ->where('id_ofl', $id_ofl)
                    ->where('entrevista_realizada', true)
                    ->groupBy('id_curri');


                $data_entrevistas = DB::table('usr_part_curri_entrevistafun as entrefun')
                    ->leftJoinSub($subQuery, 'prom', function ($join) {
                        $join->on('prom.id_curri', '=', 'entrefun.id_curri');
                    })
                    ->leftJoinSub($subQuery1, 'prom1', function ($join) {
                        $join->on('prom1.id_curri', '=', 'entrefun.id_curri');
                    })
                    ->where('entrefun.id_ofl', $id_ofl)
                    ->select([
                        'entrefun.id_part',
                        'entrefun.id_curri',
                        'entrefun.id_ofl',
                        'entrefun.id as id_entrevista',
                        'entrefun.fecha as f_entrevista',
                        'entrefun.entrevista_realizada',
                        'prom.notifica_contratar',
                        DB::raw('ROUND(prom1.valoracion_promedio, 0) as valoracion_promedio'),
                    ])
                    ->get();                


        return response()->json([
            'candidatos' => $data_candidatos,
            'entrevistas' => $data_entrevistas,
            'oferta' => $data_oferta]);
    }

    // ACTUALIZA EL ESTATUS DE LAS VACANTES
    public function update(Request $request, Ofertas $ofertas)
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $data = $request->except('_token');
        $id_ofl = $data['id_ofl'];
        $id_estatus = $data['id_estatus'];
        $confidencial = $data['confidencial'] ?? 0;
        $id_reclutador = $data['id_reclutador'] ?? null;

        // === RECHAZA SOLICITUD ===
        if ($id_estatus == 4) {
            $txt_area_observacion = $data['txt_area_observacion'] ?? '';

            DB::table('vacantes_solicitudes')
                ->where('id', $id_ofl)
                ->update([
                    'id_estatus' => $id_estatus,
                    'observacion' => $txt_area_observacion,
                    'reclutador_asignado' => Auth::id(),
                ]);

            $result = DB::table('vacantes_solicitudes as sol')
                ->select(
                    'sol.id',
                    'sol.created_at AS fecha_sol',
                    'sol.hasta AS fecha_tope',
                    'est.nameund AS unidad_economica',
                    'estsec.nameund AS seccion',
                    'pos.descpue',
                    'sol.cantidad',
                    'sol.proceso',
                    'sol.contratados',
                    'sol.id_estatus',
                    'sta.estatus',
                    'sta.icono'
                )
                ->leftJoin('posiciones as pos', 'sol.id_puesto', '=', 'pos.id')
                ->leftJoin('estructuras as est', 'est.id', '=', 'sol.id_ue')
                ->leftJoin('estructuras as estsec', 'estsec.id', '=', 'sol.id_secc')
                ->leftJoin('vacantes_estatus as sta', 'sta.id', '=', 'sol.id_estatus')
                ->where('sol.id_estatus', '<=', 3)
                ->get();
        
            $data_reclutadores = User::select(
                    'users.id',
                    DB::raw('COUNT(vacantes_solicitudes.id) AS total_vacantes')
                    )
                    ->join('usr_rol', 'usr_rol.id_usr', '=', 'users.id')
                    ->join('m_empleados', 'users.codigo', '=', 'm_empleados.id')
                    ->leftJoin('vacantes_solicitudes', function ($join) {
                        $join->on('vacantes_solicitudes.reclutador_asignado', '=', 'users.id')
                            ->where('vacantes_solicitudes.id_estatus', '<', 3);
                    })
                    ->whereIn('usr_rol.id_rol', [1, 4])
                    ->where('users.estatus', 1)
                    ->groupBy('users.id')
                    ->get();
                    
            return response()->json([
                'success' => true,
                'result' => $result,
                'stats' => $this->getStats(),
                'reclutadores' => $data_reclutadores,
                'message' => 'Solicitud rechazada correctamente.',
            ]);
        }

        // === APRUEBA SOLICITUD ===
        if ($id_estatus == 2) {
            DB::table('vacantes_solicitudes')
                ->where('id', $id_ofl)
                ->update([
                    'id_estatus' => $id_estatus,
                    'confidencial' => $confidencial,
                    'reclutador_asignado' => $id_reclutador,
                ]);

            $result = DB::table('vacantes_estatus')
                ->select('estatus', 'icono')
                ->where('id', $id_estatus)
                ->first();

            $reclutador = User::select(
                    'users.id',
                    'users.email',
                    'm_empleados.prinombre',
                    'm_empleados.priapellido',
                    'm_empleados.foto',
                    'm_empleados.color_text',
                    'm_empleados.color_bg'
                )
                ->join('m_empleados', 'users.codigo', '=', 'm_empleados.id')
                ->where('users.id', $id_reclutador)
                ->first();

            // Enviar notificación si tiene email
            if ($reclutador && $reclutador->email) {
                $loginUrl = route('login'); 
                    $data = [
                    'subject' => 'Asignación de Reclutador',
                    'body'    => "Has sido asignado como reclutador para la oferta laboral ID: $id_ofl.",
                    'html'    => '<p>Estimado/a '.$reclutador->prinombre.' '.$reclutador->priapellido.',</p>
                                <p>Se le informa que ha sido asignado como reclutador para la oferta laboral #: <strong>'.$id_ofl.'</strong>.</p>
                                <p>Favor revisar la plataforma para más detalles.</p>
                                <p><a href="'.$loginUrl.'">'.$loginUrl.'</a></p>
                                <p>Saludos,</p>
                                <p>El equipo de FOCUSTalent</p>',
                ];
                Mail::to($reclutador->email)->send(new ContactanosMailable($data));
            }
            
            $data_reclutadores = User::select(
                'users.id',
                DB::raw('COUNT(vacantes_solicitudes.id) AS total_vacantes')
                )
                ->join('usr_rol', 'usr_rol.id_usr', '=', 'users.id')
                ->join('m_empleados', 'users.codigo', '=', 'm_empleados.id')
                ->leftJoin('vacantes_solicitudes', function ($join) {
                    $join->on('vacantes_solicitudes.reclutador_asignado', '=', 'users.id')
                        ->where('vacantes_solicitudes.id_estatus', '<', 3);
                })
                ->whereIn('usr_rol.id_rol', [1, 4])
                ->where('users.estatus', 1)
                ->groupBy('users.id')
                ->get();

                
            return response()->json([
                'success' => true,
                'result' => $result,
                'stats' => $this->getStats(),
                'reclutador' => $reclutador,
                'reclutadores' => $data_reclutadores,
                'message' => 'Solicitud aprobada correctamente.',
            ]);
        }

        // Si no se cumple ninguna condición
        return response()->json(['error' => 'Estatus no válido.'], 400);
    }


    private function getStats()
    {
        return [
            'vacantes_activas' => VacanteSolicitud::where('id_estatus', '<', 3)
                ->selectRaw('SUM(cantidad) - SUM(contratados) as vacantes_activas')
                ->value('vacantes_activas'),

            'vacantes_asignadas' => VacanteSolicitud::where('id_estatus', '<', 3)
                ->whereNotNull('reclutador_asignado')
                ->selectRaw('SUM(cantidad) - SUM(contratados) as vacantes_asignadas')
                ->value('vacantes_asignadas'),

            'vacantes_sin_asignar' => VacanteSolicitud::where('id_estatus', '<', 3)
                ->whereNull('reclutador_asignado')
                ->sum('cantidad'),

            'vacantes_del_mes' => VacanteSolicitud::where('id_estatus', '<', 3)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('cantidad'),
        ];
    }

    // ELIMINA PARTICIPANTES
    public function destroy(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $id_ofl= $data['id_ofl'];
        $idparti= $data['idparti'];
        
        DB::table('usr_participantes')
        ->where('id','=', $idparti)
        ->whereNotIn('id_etapa',[6,7])           
        ->delete();

       /* $querycantproceso = DB::select("SELECT count(*)  as cantproceso FROM usr_participantes                 
        WHERE id_etapa not in (7,8) and id_ofl=$id_ofl");
        foreach ($querycantproceso as $res)
        {   $cantproceso=$res->cantproceso;}

        $querycontratados = DB::select("SELECT count(*)  as cantcontratados FROM usr_participantes                 
        WHERE id_etapa =7 and id_ofl=$id_ofl");
        foreach ($querycontratados as $res)
        {   $cantcontratados=$res->cantcontratados;}*/

        $cant_inicial=0; $cant_funcional=0; $cant_ofertalaboral=0; $cant_documentacion=0; $cant_firma=0; $cant_contratado=0; $cant_proceso=0;
        $query = DB::select("SELECT id_etapa, count(1)  as cant FROM usr_participantes                 
        WHERE id_ofl=$id_ofl group by id_etapa");
        foreach ($query as $res)
        {   
            if($res->id_etapa==1 || $res->id_etapa==2)
            {   $cant_inicial= $cant_inicial + $res->cant;}
            if($res->id_etapa==3)
            {   $cant_funcional= $cant_funcional + $res->cant;}
            if($res->id_etapa==4)
            {   $cant_ofertalaboral= $cant_ofertalaboral + $res->cant;}
            if($res->id_etapa==5)
            {   $cant_documentacion= $cant_documentacion + $res->cant;}
            if($res->id_etapa==6)
            {   $cant_firma= $cant_firma + $res->cant;}
            if($res->id_etapa==7)
            {   $cant_contratado= $cant_contratado + $res->cant;}
        }

        // cantidad en proceso NO cuenta los contratador y eliminados
        $cant_proceso= $cant_inicial + $cant_funcional + $cant_ofertalaboral + $cant_documentacion + $cant_firma;            
        DB::table('vacantes_solicitudes')->where('id','=', $id_ofl)->update(['proceso' => $cant_proceso, 'contratados' => $cant_contratado ]);
        


        //DB::table('vacantes_solicitudes') ->where('id','=', $id_ofl)->update(['proceso' => $cantproceso,'contratados' => $cantcontratados ]);
        $eliminado=0;
        $querycantproceso = DB::select("SELECT id FROM usr_participantes WHERE id= $idparti");
        foreach ($querycantproceso as $res)
        {   $eliminado=1;}

        $salidaJson=array(
            "cant_proceso"=>$cant_proceso,
            "cant_inicial"=>$cant_inicial,
            "cant_funcional"=>$cant_funcional,
            "cant_ofertalaboral"=>$cant_ofertalaboral,
            "cant_documentacion"=>$cant_documentacion,
            "cant_firma"=>$cant_firma,
            "cant_contratado"=>$cant_contratado,
            "id_ofl"=>$id_ofl,
            "eliminado"=>$eliminado,);

            echo(json_encode($salidaJson));
    }

    // BUSCA DETALLE DEL CANDIDATO
    public function ver_det_candicate(Request $request)
    {
        $id_curri = $request->input('id_curri');
        $id_ofl = $request->id_ofl;
        $id_participante = $request->input('id_participante');
        
        $data_curriculum = DB::select("
            SELECT 
                c.id, 
                c.prinombre, 
                c.segnombre,
                c.priapellido, 
                c.segapellido,

                c.color_text,
                c.color_bg,
                -- Nombre completo
                CONCAT_WS(' ', 
                    CONCAT(UPPER(LEFT(c.prinombre, 1)), LOWER(SUBSTRING(c.prinombre, 2))),
                    CONCAT(UPPER(LEFT(c.segnombre, 1)), LOWER(SUBSTRING(c.segnombre, 2)))
                ) AS nom_completo, 

                -- Apellido completo
                CONCAT_WS(' ', 
                    CONCAT(UPPER(LEFT(c.priapellido, 1)), LOWER(SUBSTRING(c.priapellido, 2))),
                    CONCAT(UPPER(LEFT(c.segapellido, 1)), LOWER(SUBSTRING(c.segapellido, 2)))
                ) AS apl_completo, 

                DATE_FORMAT(c.f_nacimiento, '%d-%m-%Y') AS f_nacimiento,

                -- Tipo de documento
                CONCAT(UPPER(LEFT(t.tipodoc, 1)), LOWER(SUBSTRING(t.tipodoc, 2))) AS tipo_doc,

                c.num_doc,
                c.num_ss,
                CONCAT(UPPER(LEFT(c.estadocivil, 1)), LOWER(SUBSTRING(c.estadocivil, 2))) AS estadocivil,
                c.id_nacionalidad,
                -- Nacionalidad
                CONCAT(UPPER(LEFT(na.nacionalidad, 1)), LOWER(SUBSTRING(na.nacionalidad, 2))) AS nacionalidad,
                
                -- Dirección compuesta
                CONCAT(
                    CONCAT(UPPER(LEFT(p.provincia, 1)), LOWER(SUBSTRING(p.provincia, 2))), ', ',
                    CONCAT(UPPER(LEFT(d.distrito, 1)), LOWER(SUBSTRING(d.distrito, 2))), ', ',
                    CONCAT(UPPER(LEFT(co.corregimiento, 1)), LOWER(SUBSTRING(co.corregimiento, 2))), ', (',
                    CONCAT(UPPER(LEFT(c.direccion, 1)), LOWER(SUBSTRING(c.direccion, 2))), ')'
                ) AS dir,

                
                c.email, 
                c.tel,  
                c.cv_doc,

                p.provincia AS prov_residencia,
                c.foto,                

                -- Educación
                e.ano, 
                e.entidad, 
                e.titulo, 
                n.nivel_educ, 
                s.estatuseduc, 
                c.permiso_trab,  
                
                
                DATE_FORMAT(c.f_vence_permiso_trab, '%d-%m-%Y') AS f_vence_permiso_trab,
                c.permiso_doc,

                -- seguridad
                c.tipo_sangre,
                IF(c.medico IS NULL, '-', c.medico ) as medico, 
                IF(c.hospital IS NULL, '-', c.hospital ) as hospital, 
                IF(c.tel_medico IS NULL, '-', c.tel_medico ) as tel_medico, 
                IF(c.sufre_alergia_medicamento = 'S', 'SI', 'NO') as sufre_alergia_medicamento, 
                IF(c.medicamento IS NULL, '-', c.medicamento ) as medicamento, 
                IF(c.sufre_lesion_laboral = 'S', 'SI', 'NO') as sufre_lesion_laboral, 
                IF(c.lesion_laboral IS NULL, '-', c.lesion_laboral ) as lesion_laboral, 
                IF(c.contacto_urgencia IS NULL, '-', c.contacto_urgencia ) as contacto_urgencia, 
                IF(c.parentesco_urgencia IS NULL, '-', c.parentesco_urgencia ) as parentesco_urgencia, 
                IF(c.tel_urgencia IS NULL, '-', c.tel_urgencia ) as tel_urgencia, 
                IF(c.discapacidad = 'No', 'NO', di.discapacidad) as discapacidad, 
                IF(c.detalle_descapacidad IS NULL, '-', c.detalle_descapacidad ) as detalle_descapacidad,
                c.examen_psicometrico,
                c.disponibilidad_viajar,
                c.verificar_informacion,
                c.informacion_verdadera


                FROM usr_part_curriculum c

                -- Educación más reciente
                LEFT JOIN (
                    SELECT e1.*
                    FROM usr_part_educacion e1
                    INNER JOIN (
                        SELECT id_curri, MAX(ano) AS max_ano
                        FROM usr_part_educacion
                        GROUP BY id_curri
                    ) e2 ON e1.id_curri = e2.id_curri AND e1.ano = e2.max_ano
                ) e ON c.id = e.id_curri

                LEFT JOIN usr_nivel_educ n ON e.nivel_educ = n.id
                LEFT JOIN usr_estatus_educ s ON e.estatuseduc = s.id
                LEFT JOIN dir_provincias p ON p.id = c.id_provincia
                LEFT JOIN dir_distritos d ON d.id = c.id_distrito
                LEFT JOIN dir_corregimientos co ON co.id = c.id_corregimiento
                LEFT JOIN usr_nacionalidad na ON na.id = c.id_nacionalidad
                LEFT JOIN usr_tipo_documento t ON t.letra = c.id_tipo_doc_letra
                LEFT JOIN usr_listdiscapacidad di ON di.id = c.discapacidad

                WHERE c.id = ?
        ", [$id_curri]);

        $data_estudios = DB::select("
            SELECT 
                CONCAT(UPPER(LEFT(n.nivel_educ , 1)), LOWER(SUBSTRING(n.nivel_educ , 2))) as nivel_educ,
                CONCAT(UPPER(LEFT(s.entidad , 1)), LOWER(SUBSTRING(s.entidad , 2))) as entidad,
                CONCAT(UPPER(LEFT(s.titulo , 1)), LOWER(SUBSTRING(s.titulo , 2))) as titulo,
                s.ano,             
                CONCAT(UPPER(LEFT(e.estatuseduc , 1)), LOWER(SUBSTRING(e.estatuseduc , 2))) as estatuseduc
            FROM usr_part_educacion s 
            LEFT JOIN usr_nivel_educ n ON n.id = s.nivel_educ
            LEFT JOIN usr_estatus_educ e ON  e.id = s.estatuseduc
            WHERE s.id_curri = ? 
            ORDER BY s.ano DESC
        ", [$id_curri]);

        $data_cursos = DB::select("
            SELECT 
                CONCAT(UPPER(LEFT(c.entidad , 1)), LOWER(SUBSTRING(c.entidad , 2))) as entidad,
                CONCAT(UPPER(LEFT(c.nombre, 1)), LOWER(SUBSTRING(c.nombre , 2))) as nombre,
                c.ano                           
            FROM usr_part_cursos_seminarios c
            WHERE c.id_curri = ? 
            ORDER BY c.ano DESC
        ", [$id_curri]);

        $data_otrosconocimientos = DB::select("
            SELECT 
                espanol,
                ingles,
                computadora,
                word,
                excel,
                powerpoint,
                IF(otros IS NULL, '-', otros ) as otros, 
                IF(sedan = 'S', 'SI', 'NO') as sedan, 
                IF(camion = 'S', 'SI', 'NO') as camion, 
                IF(trailer = 'S', 'SI', 'NO') as trailer, 
                IF(moto = 'S', 'SI', 'NO') as moto, 
                IF(montacarga = 'S', 'SI', 'NO') as montacarga
            FROM usr_part_curri_conocimiento_adicional 
            WHERE id_curri = ?
        ", [$id_curri]);

        $data_referencia_personal = DB::select("
            SELECT id,
                IF(nombre IS NULL, '-', nombre) as nombre,
                IF(direccion IS NULL, '-', direccion) as direccion,
                IF(direccion IS NULL, '-', direccion) as direccion,
                IF(telefono IS NULL, '-', telefono) as telefono,
                validado_por
            FROM usr_part_referencias_personales
            WHERE id_curri = ?
        ", [$id_curri]);

        $data_experiencia_laboral = DB::select("
            SELECT r.id,
                IF(r.empresa IS NULL, '-', r.empresa) as empresa, 
                IF(r.puesto IS NULL, '-', r.puesto) as puesto, 
                IF(r.subarea IS NULL, '-', r.subarea) as area, 
                IF(r.desde IS NULL, '-', DATE_FORMAT(r.desde, '%d-%m-%Y')) as desde, 
                IF(r.hasta IS NULL, '-', DATE_FORMAT(r.hasta, '%d-%m-%Y')) as hasta,             
                IF(r.motivo_salida IS NULL, '-', r.motivo_salida) as motivo_salida, 
                IF(r.telefono IS NULL, '-', r.telefono) as telefono, 
                IF(r.direccion IS NULL, '-', r.direccion) as direccion, 
                IF(r.salario IS NULL, '-', r.salario) as salario, 
                IF(r.jefe IS NULL, '-', r.jefe) as jefe,
                validado_por
            FROM usr_part_experiencia_laboral r
            WHERE r.id_curri = ? 
            ORDER BY r.desde DESC
        ", [$id_curri]);

        $data_familiares = DB::select("
            SELECT 
                CONCAT(UPPER(LEFT(nombre , 1)), LOWER(SUBSTRING(nombre , 2))) as nombre,
                CONCAT(UPPER(LEFT(parentesco , 1)), LOWER(SUBSTRING(parentesco , 2))) as parentesco,
                IF(unidad IS NULL, '-', unidad) as unidad
            FROM usr_part_familiares_empresa
            WHERE id_curri = ?
        ", [$id_curri]);

        $data_dependientes = DB::select("
            SELECT 
                d.nombre,
                CONCAT(UPPER(LEFT(d.parentesco , 1)), LOWER(SUBSTRING(d.parentesco , 2))) as parentesco,
                IF(d.f_nacimiento IS NULL, '-', DATE_FORMAT(d.f_nacimiento, '%d-%m-%Y')) as f_nacimiento
            FROM usr_part_dependientes d
            WHERE d.id_curri = ? 
            ORDER BY d.f_nacimiento ASC
        ", [$id_curri]);

        $datos_calce = DB::select("
            WITH apl AS (
                SELECT pa1.id, pa1.curriculum_id
                FROM pruebas_apl pa1
                INNER JOIN (
                    SELECT curriculum_id, MAX(fecha_realizada) AS max_fecha
                    FROM pruebas_apl
                    WHERE curriculum_id = ?
                    GROUP BY curriculum_id
                ) pa2 ON pa1.curriculum_id = pa2.curriculum_id 
                    AND pa1.fecha_realizada = pa2.max_fecha
            ),
            calce AS (
                SELECT 
                    c.nombre AS competencia, 
                    c.color,
                    r.idtipocomp, 
                    r.esperado, 
                    rapl.puntaje,
                    ROUND((rapl.puntaje / r.esperado) * 100, 0) AS porcentaje
                FROM usr_participantes pa 
                LEFT JOIN posiciones p ON p.id = pa.id_puesto
                LEFT JOIN descriptivos d ON d.id = p.iddf
                LEFT JOIN reljercomp r ON d.idjer = r.idjer
                LEFT JOIN competencias c ON c.id = r.idcomp
                LEFT JOIN apl a ON a.curriculum_id = pa.id_part_curriculum
                LEFT JOIN pruebas_resultados_apl rapl 
                    ON rapl.prueba_id = a.id AND rapl.competencia_id = r.idcomp
                WHERE pa.id = ?
                AND pa.id_part_curriculum = ?
            )
            SELECT *,
                (SELECT ROUND(AVG(porcentaje), 0) FROM calce) AS promedio
            FROM calce
            ORDER BY idtipocomp, competencia
            ", [$id_curri, $id_participante, $id_curri]);

            // Como el promedio vendrá en cada fila:
            $promedio_calce = count($datos_calce) > 0 ? $datos_calce[0]->promedio : 0;
                
        
        $data_entrevista_ini = UsrPartCurriEntrevistaini::with('preguntas')
                ->where('id_curri', $id_curri)
                ->where('id_ofl', $id_ofl)
                ->first();

            if ($data_entrevista_ini) {
                // Puedes agregar un campo formateado a mano
                $data_entrevista_ini->fecha_actualizacion = $data_entrevista_ini->updated_at->format('d-m-Y');
            }

        $data_docs = usr_part_curri_docattach::where('id_curri', $id_curri)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($doc) {
                    $doc->fecha_registro = Carbon::parse($doc->created_at)->format('d-m-Y');
                    return $doc;
            });       

        $data_entrevista_fun = usr_part_curri_entrevistafun::where('id_curri', $id_curri)
            ->where('id_part', $id_participante)
            ->leftJoin('m_empleados as me', 'me.email', '=', 'usr_part_curri_entrevistafun.email_entrevistador')            
            ->leftJoin('usr_participantes as pa', 'pa.id', '=', 'usr_part_curri_entrevistafun.id_part')
            ->selectRaw("usr_part_curri_entrevistafun.*,
                DATE_FORMAT(usr_part_curri_entrevistafun.fecha, '%Y-%m-%d') as fecha_corta, 
                CONCAT(UPPER(LEFT(me.prinombre, 1)), LOWER(SUBSTRING(me.prinombre, 2))) AS nombre_entrevistador,
                CONCAT(UPPER(LEFT(me.priapellido, 1)), LOWER(SUBSTRING(me.priapellido, 2))) AS apellido_entrevistador,                
                me.foto as foto_entrevistador,me.color_text,me.color_bg,
                pa.id_etapa
                ")
            ->orderByRaw("
                CASE 
                    WHEN usr_part_curri_entrevistafun.fecha IS NOT NULL AND usr_part_curri_entrevistafun.hora IS NOT NULL THEN usr_part_curri_entrevistafun.fecha
                    ELSE usr_part_curri_entrevistafun.created_at
                END ASC")
            ->orderByRaw("
                CASE 
                    WHEN usr_part_curri_entrevistafun.fecha IS NOT NULL AND usr_part_curri_entrevistafun.hora IS NOT NULL THEN STR_TO_DATE(usr_part_curri_entrevistafun.hora, '%H:%i')
                    ELSE usr_part_curri_entrevistafun.created_at
                END ASC")
            ->get()
            
            ->map(function ($item) {
                $item->fecha_formateada = $item->fecha ? ucfirst(Carbon::parse($item->fecha)->isoFormat('dddd D [de] MMMM YYYY')) : null;
                $item->fecha_real_formateada = $item->f_realEntrevista ? ucfirst(Carbon::parse($item->f_realEntrevista)->isoFormat('dddd D [de] MMMM YYYY')): null;            

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
        
            $candidato = usr_participantes::where('id', $id_participante)
                ->select([
                    'id_etapa',
                    DB::raw("COALESCE(motivo_descarte, '') AS motivo_descarte"),
                    DB::raw("COALESCE(detalle_descarte, '') AS detalle_descarte")
                ])
                ->first();

        $data_cartas_ofertas= DB::table('usr_partici_cartaofl')
            ->where('id_participante', $id_participante)
            ->where('id_ofl', $id_ofl)
            ->select('id', 'finicio', 'salario', 'sel_tipo_salario',  'sel_tipo_contrato','sel_tipo_salario', 'url_carta_oferta','generada_por', 'estado', 'aceptacion_ofl', 'faceptacion',
                DB::raw("DATE_FORMAT(finicio, '%d-%m-%Y') as finicio_formateado"),
                DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as fecha_registro"))
            ->first();

        return response()->json([
            'datos_personales' => $data_curriculum,
            'educacion' => $data_estudios,
            'cursos' => $data_cursos,
            'otrosconocimientos' => $data_otrosconocimientos,
            'referencia_personal' => $data_referencia_personal,
            'experiencia_laboral' => $data_experiencia_laboral,
            'familiares' => $data_familiares,
            'dependientes' => $data_dependientes,
            'prueba_disc' => PruebaDisc::where('curriculum_id', $id_curri)->selectRaw("*, DATE_FORMAT(fecha_realizada, '%d-%m-%Y') as fecha_realizada")->orderBy('fecha_realizada', 'desc')->first(),       
            'prueba_razi' => PruebaRazi::where('curriculum_id', $id_curri)->selectRaw("*, DATE_FORMAT(fecha_realizada, '%d-%m-%Y') as fecha_realizada")->orderBy('fecha_realizada', 'desc')->first(),      
            'prueba_veritas' => PruebaVeritas::where('curriculum_id', $id_curri)->selectRaw("*, DATE_FORMAT(fecha_realizada, '%d-%m-%Y') as fecha_realizada")->orderBy('fecha_realizada', 'desc')->first(),
            'prueba_apl' => PruebaApl::where('curriculum_id', $id_curri)->selectRaw("*, DATE_FORMAT(fecha_realizada, '%d-%m-%Y') as fecha_realizada")->orderBy('fecha_realizada', 'desc')->first(),
            'datos_calce' => $datos_calce,
            'promedio_calce' => $promedio_calce,
            'entrevista_ini' => $data_entrevista_ini,
            'docs' => $data_docs,
            'data_entrevista_fun'=> $data_entrevista_fun,
            'candidato' => $candidato,
            'cartas_ofertas' => $data_cartas_ofertas
        ]);
    }

    // GUARDA ENTREVISTA FUNCIONAL
    public function save_ent_funcional(Request $request)
    {   
        $request->validate([
            'id' => 'required|integer',
            'email_entrevistador' => 'required|email',
            'mail_candidato' => 'required|email',
            'fecha' => 'required|date',
            'hora' => 'required',
            'lugar' => 'required|string|max:255',
            'comentarios' => 'nullable|string',
            'id_ofl' => 'required|integer',
            'id_curri' => 'required|integer',
            'id_part' => 'required|integer',
        ]);

        if ($request->id == 0) {
            $entrevista = new usr_part_curri_entrevistafun();
            $entrevista->id_curri = $request->id_curri; 
            $entrevista->id_part = $request->id_part;
            $entrevista->id_ofl = $request->id_ofl;
        } else {
            $entrevista = usr_part_curri_entrevistafun::findOrFail($request->id);
        }

        $entrevista->email_entrevistador = $request->email_entrevistador;
        $entrevista->fecha = $request->fecha;
        $entrevista->hora = $request->hora;
        $entrevista->lugar_entrevista = $request->lugar;
        $entrevista->observaciones = $request->comentarios ?? '';
        $entrevista->notificado = ($request->enviar_agenda == 's') ? 1 : 0;
        $entrevista->opcionesContratacion = ($request->chk_opt_contrata == 's') ? 1 : 0;
        $entrevista->preguntas_entrevistas = ($request->chk_opt_preguntas_entrevistas == 's') ? 1 : 0;
        $entrevista->save();

        // Actualizar el estado del participante a "Entrevita funcional"
        $participante = usr_participantes::find($request->id_part);
        if (!$participante) {
            return response()->json(['success' => false, 'message' => 'Participante no encontrado.'], 404);
        }
 
        // Actualizar la etapa del participante
        $participante->id_etapa = 6; // Asignar la etapa de entrevita funcional
        $participante->motivo_descarte = null; // Guardar el motivo
        $participante->detalle_descarte = null; // Guardar detalle
        $participante->save();

        if ($request->enviar_agenda == 's') {
            $data = [
                'nom_candidato' => $request->nom_candidato,
                'puesto' => $request->reclutamiento_nom_puesto,
                'unidad' => $request->reclutamiento_nom_unidad,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'lugar' => $request->lugar,
                'comentarios' => $request->comentarios,
            ];
            Mail::bcc([$request->email_entrevistador, $request->mail_candidato])->send(new EntrevistaFuncionalMail($data));
        }


        $data_entrevista_fun = usr_part_curri_entrevistafun::where('usr_part_curri_entrevistafun.id', $entrevista->id)
            ->leftJoin('m_empleados as me', 'me.email', '=', 'usr_part_curri_entrevistafun.email_entrevistador')
            ->leftJoin('usr_participantes as pa', 'pa.id', '=', 'usr_part_curri_entrevistafun.id_part')
            ->selectRaw("
                usr_part_curri_entrevistafun.*,
                DATE_FORMAT(usr_part_curri_entrevistafun.fecha, '%Y-%m-%d') as fecha_corta, 
                CONCAT(UPPER(LEFT(me.prinombre, 1)), LOWER(SUBSTRING(me.prinombre, 2))) AS nombre_entrevistador,
                CONCAT(UPPER(LEFT(me.priapellido, 1)), LOWER(SUBSTRING(me.priapellido, 2))) AS apellido_entrevistador,                
                me.foto as foto_entrevistador,me.color_text,me.color_bg,
                pa.id_etapa
            ")
            ->first();

        if ($data_entrevista_fun) {
            $data_entrevista_fun->fecha_formateada = $data_entrevista_fun->fecha ? ucfirst(Carbon::parse($data_entrevista_fun->fecha)->isoFormat('dddd D [de] MMMM YYYY')) : null;
            $data_entrevista_fun->hora_formateada = $data_entrevista_fun->hora ? Carbon::parse($data_entrevista_fun->hora)->format('H:i: A') : '';
        }

        return response()->json([
            'success' => true,
            'id' => $entrevista->id,
            'entrevista_fun' => $data_entrevista_fun
        ]);

    }
    // VER ENTREVISTA FUNCIONAL
    public function viewEntFuncional(Request $request)
    {
        $data_entrevista_fun = usr_part_curri_entrevistafun::where('usr_part_curri_entrevistafun.id', $request->idEntrevista)
        ->leftJoin('m_empleados as me', 'me.email', '=', 'usr_part_curri_entrevistafun.email_entrevistador')
        ->leftJoin('usr_participantes as pa', 'pa.id', '=', 'usr_part_curri_entrevistafun.id_part')
        ->selectRaw("
            usr_part_curri_entrevistafun.*,
            DATE_FORMAT(usr_part_curri_entrevistafun.fecha, '%Y-%m-%d') as fecha_corta, 
            CONCAT(UPPER(LEFT(me.prinombre, 1)), LOWER(SUBSTRING(me.prinombre, 2))) AS nombre_entrevistador,
            CONCAT(UPPER(LEFT(me.priapellido, 1)), LOWER(SUBSTRING(me.priapellido, 2))) AS apellido_entrevistador,                
            pa.id_etapa")
        ->first();

        if ($data_entrevista_fun) {
            $data_entrevista_fun->fecha_formateada = $data_entrevista_fun->fecha ? ucfirst(Carbon::parse($data_entrevista_fun->fecha)->isoFormat('dddd D [de] MMMM YYYY')) : null;
            $data_entrevista_fun->hora_formateada = $data_entrevista_fun->hora ? Carbon::parse($data_entrevista_fun->hora)->format('H:i: A') : '';
        }

        return response()->json([
            'success' => true,
            'entrevista_fun' => $data_entrevista_fun
        ]);

    }

    public function saveDescarte(Request $request)
    {   
        $data = $request->except('_token');
        $id_part = $data['id_part'] ?? null;
        $id_curri = $data['id_curri'] ?? null;
        $id_ofl = $data['id_ofl'] ?? null;
        $motivo = $data['motivo_descarte'] ?? null;

        if (!$id_curri || !$id_part || !$id_ofl) {
            return response()->json(['success' => false, 'message' => 'ID de participante, currículum y oferta laboral requeridos.'], 400);
        }

        // Actualizar el estado del participante a "Descarte"
        $participante = usr_participantes::where('id', $id_part)->first();
        if (!$participante) {
            return response()->json(['success' => false, 'message' => 'Participante no encontrado.'], 404);
        }

        // Actualizar la etapa del participante
        $participante->id_etapa = 12; // Asignar la etapa de descarte
        $participante->motivo_descarte = $motivo; // Guardar el motivo de descarte
        $participante->detalle_descarte = $data['detalle_descarte'] ?? null; // Guardar detalle de descarte
        $participante->save();

        // Limpiar entrevista agendada (si no se ha realizado)
        $participante_entrevista = usr_part_curri_entrevistafun::where('id_part', $id_part)
            ->where('entrevista_realizada', 0) // 0 = no realizada
            ->first();

        if ($participante_entrevista) {
            $participante_entrevista->fecha = null;
            $participante_entrevista->hora = null;
            $participante_entrevista->notificado = 0;
            $participante_entrevista->save();
        }



        // Actualizar usr_part_curriculum si chk_descarta_bd es s
        if (isset($data['chk_descarta_bd']) && $data['chk_descarta_bd'] === 's') {
            $curriculum = usr_part_curriculum::where('id', $id_curri)->first();
            if ($curriculum) {
                // Actualizar el estado del currículum a "Descarte"
                $curriculum->estado_registro = 2; // Asignar estado de descarte de futuras busquedas y ofertas laborales
                $curriculum->motivo_descarte= $motivo; // Guardar el motivo de descarte,
                $curriculum->detalle_descarte = $data['detalle_descarte'] ?? null; // Guardar detalle de descarte
                $curriculum->descartado_por = Auth::user()->email; // Guardar quién lo descartó
                $curriculum->save();
            }
        }

         // Buscar entrevista existente
        $entrevista = UsrPartCurriEntrevistaini::where('id_curri', $id_curri)->first();

        if (!$entrevista) {
            $entrevista = new UsrPartCurriEntrevistaini();
            $entrevista->id_curri = $id_curri;
        }
        return response()->json(['success' => true, 'message' => 'Participante descartado correctamente.']);
    }

    // GUARDA ENTREVITA INCIAL
    public function save_entrevista_ini(Request $request)
    {
        $data = $request->except('_token');
        $id_participante = $data['id_participante'] ?? null;
        $id_curri = $data['id_curri'] ?? null;
        $id_ofl = $data['id_ofl'] ?? null;
        $trabajando = $data['trabajando'] ?? null;
        $empresa = $data['empresa'] ?? null;
        $puesto = $data['puesto'] ?? null;
        $salario = $data['salario'] ?? null;
        $beneficios = $data['beneficios'] ?? null;
        $aspiracion_salarial = $data['aspiracion_salarial'] ?? null;
        $comentarios = $data['comentarios_adicionales'] ?? null;
        $preguntas_respuestas = $data['preguntas'] ?? [];

        if (!$id_curri) {   return response()->json(['success' => false, 'message' => 'ID de currículum requerido.'], 400);}

        // Buscar entrevista existente
        $entrevista = UsrPartCurriEntrevistaini::where('id_curri', $id_curri)->first();

        if (!$entrevista) {
            $entrevista = new UsrPartCurriEntrevistaini();
            $entrevista->id_curri = $id_curri;
        }

        // Asignar o actualizar valores
        $entrevista->esta_laborando = $trabajando;
        $entrevista->empresa_actual = $empresa;
        $entrevista->posicion_actual = $puesto;
        $entrevista->salario_actual = $salario;
        $entrevista->beneficios_adicionales = $beneficios;
        $entrevista->aspiracion_salarial = $aspiracion_salarial;
        $entrevista->comentarios_adicionales = $comentarios;
        $entrevista->por = Auth::user()->email;
        $entrevista->id_ofl = $id_ofl;

        $entrevista->save();

        // Limpiar preguntas anteriores (si existen)
        $entrevista->preguntas()->delete();

        // Guardar nuevas preguntas
        foreach ($preguntas_respuestas as $item) {
            if (!empty($item['pregunta']) && !empty($item['respuesta'])) {
                $entrevista->preguntas()->create([
                    'pregunta' => $item['pregunta'],
                    'respuesta' => $item['respuesta'],
                ]);
            }
        }
        // Obtener el participante
        $participante = usr_participantes::where('id', $id_participante)->first();

        // ID de la etapa de entrevista inicial
        $id_etapa_entrevista_inicial = 4;

        if ($participante) {
            // Verificamos si debemos actualizar la etapa
            if ($participante->id_etapa < $id_etapa_entrevista_inicial) {
                $participante->id_etapa = $id_etapa_entrevista_inicial;
            }
            // Siempre actualizar aspiración salarial
            $participante->aspiracion_sal = $aspiracion_salarial;
            $participante->save();
        }

        
        return response()->json([
            'success' => true,
            'message' => 'Entrevista guardada correctamente.',
            'fecha_actualizacion' => $entrevista->updated_at->format('d-m-Y'),
            'por' => Auth::user()->email,
        ]);
    }

    //  IMPORTANDO DOCUMENTOS
    public function importardocs(Request $request)
    {
        $id_curri = $request->input('id_curri');
        $tipo_file = $request->input('tipo_file');

        // Validar archivos (si existen)
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240', // Max 10MB
            'tipo_file' => 'required',
        ]);

        // === record policivo ===
            $archivo = null;
            $nombre =null;
            $id_doc = null;
            $f_create = null;
            if ($request->hasFile('pdf_file') && $request->file('pdf_file')->isValid()) {
                $archivo = $request->file('pdf_file');
                $nombre = $tipo_file.'_' . uniqid() . '.' . $archivo->getClientOriginalExtension(); 
                $path = $archivo->storeAs('docs/'.$tipo_file, $nombre, 'public');
                $archivo_name = 'storage/' . $path;
                $res = usr_part_curri_docattach::create([
                    'id_curri' => $id_curri,
                    'iddoc' => $tipo_file,
                    'nomdoc' => $nombre,
                    'downdoc' => $archivo_name,
                ]);
                $id_doc = $res->id;
                $f_create = $res->created_at;
                if ($res) { $f_create = $res->created_at->format('d-m-Y');}
            }

        return response()->json([
            'id_doc' => $id_doc,
            'nombre' => $nombre,
            'downdoc' => $archivo_name,
            'f_create' => $f_create,
            'message' => 'Documento almacenado correctamente',
        ]);

    }

    //  ELIMINANDO DOCUMENTOS
    public function deldocs(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $id_doc = $request->input('id_doc');
            $tipo_doc = $request->input('doc'); // Renombrado para evitar confusión

            // === Caso: Carta de Oferta - Eliminar completamente ===
            if ($tipo_doc === 'cartaofl') {
                $carta = Usr_partici_cartaofl::find($id_doc);
                if (!$carta) {
                    return response()->json(['message' => 'Carta Oferta no encontrada'], 404);
                }

                if (Storage::disk('public')->exists(str_replace('storage/', '', $carta->url_carta_oferta))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $carta->url_carta_oferta));
                }

                     
                DB::table('usr_participantes')
                    ->where('id', $carta->id_participante)
                    ->update([
                        'id_etapa' => 6
                    ]);

                // Si quieres eliminar también beneficios
                $carta->beneficios()->delete();
                $carta->delete();

                return response()->json(['message' => 'Carta Oferta eliminada correctamente']);
            }

            // === Caso: Carta de Oferta - Solo resetear aceptación ===
            if ($tipo_doc === 'cartaoflacept') {
                $carta = Usr_partici_cartaofl::find($id_doc);
                if (!$carta) {
                    return response()->json(['message' => 'Carta Oferta no encontrada'], 404);
                }

                if (Storage::disk('public')->exists(str_replace('storage/', '', $carta->aceptacion_ofl))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $carta->aceptacion_ofl));
                }

                DB::table('usr_partici_cartaofl')
                    ->where('id', $id_doc)
                    ->update([
                        'aceptacion_ofl' => null,
                        'faceptacion' => null,
                        'estado' => 1
                    ]);

                $id_oferta = DB::table('usr_participantes')
                    ->where('id', $carta->id_participante)
                    ->value('id_ofl');
                    
                DB::table('usr_participantes')
                    ->where('id', $carta->id_participante)
                    ->update([
                        'id_etapa' => 8
                    ]);

                $data_cartas_ofertas = DB::table('usr_partici_cartaofl')
                    ->where('id_participante', $carta->id_participante)
                    ->where('id_ofl', $id_oferta)
                    ->select(
                        'id', 'finicio', 'salario', 'sel_tipo_salario', 'sel_tipo_contrato',
                        'url_carta_oferta', 'generada_por', 'estado', 'aceptacion_ofl', 'faceptacion',
                        DB::raw("DATE_FORMAT(finicio, '%d-%m-%Y') as finicio_formateado"),
                        DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as fecha_registro")
                    )
                    ->first();

                return response()->json([
                    'message' => 'La Carta Oferta firmada ha sido eliminada',
                    'cartas_ofertas' => $data_cartas_ofertas
                ]);
            }

            // === Caso: Documento Currículum ===
            $doc_model = usr_part_curri_docattach::find($id_doc);
            if (!$doc_model) {
                return response()->json(['message' => 'Documento no encontrado'], 404);
            }

            if (Storage::disk('public')->exists(str_replace('storage/', '', $doc_model->downdoc))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $doc_model->downdoc));
            }

            $doc_model->delete();
            return response()->json(['message' => 'Documento eliminado correctamente']);
        });
    }

    public function valida_ref(Request $request)
    {
        $data = $request->except('_token');
        $id_ref = $data['id_ref'] ?? null;

        if (!$id_ref) { 
            return response()->json(['success' => false, 'message' => 'ID de referencia no proporcionado.'], 400);
        }
        $referencia =null;
        if($data['tipo']=='p')
        {   $referencia = DB::table('usr_part_referencias_personales as r')
                ->leftJoin('users as u', 'u.id', '=', 'r.validado_por')
                ->select(
                    'r.vinculo',
                    'r.forma_de_ser',
                    'r.rel_sociales_sanas',
                    'r.responsable',
                    'r.cortes',
                    'r.cooperador',
                    'r.probl_honestidad',
                    'r.lo_contrataria',
                    'r.porq',
                    'r.validado_por',
                    'u.name as nombre_validador',
                    DB::raw("DATE_FORMAT(r.f_validacion, '%d-%m-%Y') AS f_validacion")
                )
                ->where('r.id', $id_ref)
                ->first();

        }
        if($data['tipo']=='l')
        {
            $referencia = DB::table('usr_part_experiencia_laboral as r')
                ->leftJoin('users as u', 'u.id', '=', 'r.validado_por')
                ->select(
                    'r.periodo_laborado',
                    'r.motivo_salida_validado',
                    'r.reljefe',
                    'r.relcompanero',
                    'r.puntualidad',
                    'r.honestidad',
                    'r.responsable',
                    'r.cooperador',
                    'r.cortes',
                    'r.locontrataria',
                    'r.observacion',
                    'r.brindada_por',
                    'r.puesto_por',
                    'r.validado_por',
                    'u.name as nombre_validador',
                    DB::raw("DATE_FORMAT(r.f_validacion, '%d-%m-%Y') AS f_validacion")
                )
                ->where('r.id', $id_ref)
                ->first();
        }

        if (!$referencia) {
            return response()->json(['success' => false, 'message' => 'Referencia no encontrada.'], 404);
        }

        return response()->json(['success' => true, 'referencia' => $referencia]);
    }

    public function update_validacion_ref_p(Request $request)
    {
        $data = $request->except('_token');

        $id_participante = $data['id_participante'];
        DB::table('usr_part_referencias_personales')
            ->where('id', $data['id_ref'])
            ->update([
                'vinculo' => $data['vinculo'],
                'forma_de_ser' => $data['formardeser'],
                'rel_sociales_sanas' => $data['relaciones_ref_p'],
                'responsable' => $data['responsable_ref_p'],
                'cortes' => $data['cortes_ref_p'],
                'cooperador' => $data['cooperador_ref_p'],
                'probl_honestidad' => $data['honestidad_ref_p'],
                'lo_contrataria' => $data['contrataria_ref_p'],
                'porq' => $data['validacion_ref_p_porq'],
                'validado_por' => Auth::user()->id,
                'f_validacion' => now()
            ]);

        $participante = usr_participantes::where('id', $id_participante)->first();

        // ID de la etapa de entrevista inicial
        $id_etapa = 3;
        if ($participante) {
            // Verificamos si debemos actualizar la etapa
            if ($participante->id_etapa < $id_etapa) {
                $participante->id_etapa = $id_etapa;
            }
             $participante->save();
        }
        return response()->json(['success' => true]);
    }
    
    public function update_validacion_ref_l(Request $request)
    {
        $data = $request->except('_token');
        $id_participante = $data['id_participante'];
        DB::table('usr_part_experiencia_laboral')
            ->where('id', $data['id_ref'])
            ->update([
                'periodo_laborado' => $data['periodo'],
                'motivo_salida_validado' => $data['motivo_salida'],
                'reljefe' => $data['reljefe_ref_l'],
                'relcompanero' => $data['relcompa_ref_l'],
                'puntualidad' => $data['puntualidad_ref_l'],
                'honestidad' => $data['honestidad_ref_l'],
                'responsable' => $data['responsable_ref_l'],
                'cooperador' => $data['cooperador_ref_l'],
                'cortes' => $data['cortes_ref_l'],
                'locontrataria' => $data['locontrataria_ref_l'],
                'observacion' => $data['validacion_ref_l_obs'],
                'brindada_por' => $data['referencias_por'],
                'puesto_por' => $data['referencias_puesto_por'],
                'validado_por' => Auth::user()->id,
                'f_validacion' => now()
            ]);

        $participante = usr_participantes::where('id', $id_participante)->first();

        // ID de la etapa de entrevista inicial
        $id_etapa = 3;
        if ($participante) {
            // Verificamos si debemos actualizar la etapa
            if ($participante->id_etapa < $id_etapa) {
                $participante->id_etapa = $id_etapa;
            }
             $participante->save();
        }
        return response()->json(['success' => true]);
    }

    // VALIDACIÓN DE SIPE
    public function valsipe(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $val= $data['val']; 
        $paso=5;
		$id_participante= $data['id_participante']; 
        DB::table('usr_participantes')->where('id','=', $id_participante)->update(['valida_sipe' => $val]);
        if($val==0)
        {   DB::table('usr_participantes')->where('id','=', $$id_participante ) ->update(['id_etapa' => $paso]);}
    }

    // VALIDACIÓN MARCACION
    public function valmarcacion(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $val= $data['val']; 
        $paso=5;
		$id_participante= $data['id_participante']; 
        DB::table('usr_participantes')->where('id','=', $id_participante)->update(['marcacion' => $val]);
        if($val==0)
        {   DB::table('usr_participantes')->where('id','=', $$id_participante ) ->update(['id_etapa' => $paso]);}
    }
    

    // ELIMINA DOCUMENTOS ADJUNTOS EN EL PROCESO DE CONTRATACIÓN
    public function deldoc(Ofertas $ofertas)
    {   
        if (isset(Auth::user()->id)) 
        {
            $data= request()->except('_token');
            $optdoc= $data['optdoc'];  
            
            if($optdoc=='rp') // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
            {
                $id_curri= $data['id_curri'];
                $id_participante= $data['id_participante'];
                
                $id_doc=1; // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
            
                $query = DB::select("SELECT nomdoc
                FROM usr_part_curri_docattach AS docatch 
                WHERE id_participante=$id_participante and id_curri=$id_curri and iddoc= $id_doc");

                foreach ($query as $res)
                {   $nomdoc=$res->nomdoc;
                    unlink($nomdoc);
                    $paso=2;
                    DB::table('usr_part_curri_docattach')->where('iddoc','=', $id_doc)->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
                    DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa' => $paso]);
                }
                $query_part = DB::select("SELECT  partici_status.banges as banges
                    FROM usr_participantes AS partici 
                    LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                    WHERE partici.id=$id_participante");

                    foreach ($query_part as $res)
                    {   $banges=$res->banges;}
                    
                    $salidaJson=array("banges"=>$banges,
                                        "paso"=>$paso,);

                    echo(json_encode($salidaJson));
            }
            else
            {   if($optdoc=='aprob') // eliminando archivo de aprobación por parte de jefe de la ofera laboral
                {   $paso=4;
                    $id= $data['id'];
                    $resp='-';
                    $query = DB::select("SELECT aprobacion_ofl as url_doc,id_participante  FROM usr_partici_cartaofl WHERE id=$id and aceptacion_ofl is null");
                    foreach ($query as $res)
                    {   $nomdoc=str_replace('/storage', "", $res->url_doc);
                        $id_participante=$res->id_participante;
                        Storage::disk('public')->delete($nomdoc);
                        DB::table('usr_partici_cartaofl')->where('id','=', $id)->where('aceptacion_ofl','=', null)->update(['aprobacion_ofl' => null]);
                        DB::table('usr_participantes')->where('id','=', $id_participante) ->update(['id_etapa' => $paso]);
                        $query_part = DB::select("SELECT  partici_status.banges as banges
                                FROM usr_participantes AS partici 
                                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                                WHERE partici.id=$id_participante");
                                foreach ($query_part as $res)
                                {   $banges=$res->banges;}
                        $resp=1;
                    }
                    $salidaJson=array("resp"=>$resp,
                    "paso"=>$paso,
                    "banges"=>$banges,);
                    echo(json_encode($salidaJson));
                }
                else
                {   if($optdoc=='oflacept') // eliminando archivo de aceptación por parte del candidato
                    {   $paso=4;
                        $id= $data['id'];
                        $resp='-';
                        $banges='-';
                        $query = DB::select("SELECT aceptacion_ofl as url_doc,id_participante  FROM usr_partici_cartaofl WHERE id= $id");
                        foreach ($query as $res)
                        {   $nomdoc=str_replace('/storage', "", $res->url_doc);
                            $id_participante=$res->id_participante;
                            Storage::disk('public')->delete($nomdoc);
                            $resp=1;
                            DB::table('usr_partici_cartaofl')->where('id','=', $id)->update(['aceptacion_ofl' => null,'estado' => 5,'faceptacion'=> null]);
                            DB::table('usr_participantes')->where('id','=', $id_participante) ->update(['id_etapa' => $paso]);
                            $query_part = DB::select("SELECT  partici_status.banges as banges
                                FROM usr_participantes AS partici 
                                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                                WHERE partici.id=$id_participante");
                    
                                foreach ($query_part as $res)
                                {   $banges=$res->banges;}
                        }                        
                        $salidaJson=array("resp"=>$resp,
                        "paso"=>$paso,
                        "banges"=>$banges,);
                        echo(json_encode($salidaJson));
                    }
                    else
                    {   $id= $data['id'];
                        $resp='-';
                        $banges='-';
                        // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
                        if($data['optdoc']=='record'){  $id_doc=1; $paso=2; }
                        if($data['optdoc']=='ced'){  $id_doc=2; $paso=5; }
                        if($data['optdoc']=='certificado_nacimiento'){  $id_doc=3; $paso=5;  }
                        if($data['optdoc']=='carnet_css'){  $id_doc=4; $paso=5;  }
                        if($data['optdoc']=='constancia_dir'){  $id_doc=5; $paso=5;  }
                        if($data['optdoc']=='dimploma'){  $id_doc=6; $paso=5;    }
                        if($data['optdoc']=='foto'){  $id_doc=7; $paso=5;   }
                        
                        $query = DB::select("SELECT nomdoc as url_doc, id_participante FROM usr_part_curri_docattach WHERE id=$id and iddoc=$id_doc");
                        foreach ($query as $res)
                        {   $nomdoc=str_replace('/storage', "", $res->url_doc);
                            $id_participante=$res->id_participante;
                            Storage::disk('public')->delete($nomdoc);
                            DB::table('usr_part_curri_docattach')->where('id','=', $id)->where('iddoc','=', $id_doc)->delete();
                            $resp=1;
                            
                            DB::table('usr_participantes')->where('id','=', $id_participante) ->update(['id_etapa' => $paso]);
                            $query_part = DB::select("SELECT  partici_status.banges as banges
                                FROM usr_participantes AS partici 
                                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                                WHERE partici.id=$id_participante");
                    
                                foreach ($query_part as $res)
                                {   $banges=$res->banges;}

                        }
                        $salidaJson=array("resp"=>$resp,
                        "paso"=>$paso,
                        "banges"=>$banges,);
                        echo(json_encode($salidaJson));
                    }
                }
            }
        }
        else{   return view('auth.login');}
    }
    
    // INSERTA LOS DATOS Y QUE ESTÉN DISPONIBLES PARA LA CREACIÓN DE LAS CARTAS DE OFERTAS LABOTALES

    public function crearCartaOferta(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $id_part = $data['id_part'];
            $id_oferta = $data['id_ofl'];
            $sel_cia = $data['sel_cia'];
            $sel_ceco = $data['sel_ceco'];
            $salario = $data['salario'];
            $finicio = $data['fecha_inicio'];
            $fterminacion = $data['fecha_terminacion'] ?? null;
            $tipo_contrato = $data['tipo_contrato'];
            $tipo_salario = $data['tipo_salario'];
            $txt_plazo_nombramiento = $data['txt_plazo_nombramiento'] ?? null;
            $sel_firmante = $data['sel_firmante'] ?? null;

            $candidato = DB::table('usr_participantes as part')
                ->leftJoin('usr_part_curriculum as c', 'c.id', '=', 'part.id_part_curriculum')
                ->leftJoin('posiciones as p', 'p.id', '=', 'part.id_puesto')
                ->leftJoin('estructuras as e1', 'e1.id', '=', 'p.idue')
                ->select(
                    'c.prinombre', 'c.segnombre', 'c.priapellido', 'c.segapellido',
                    'c.genero', 'c.num_doc', 'p.descpue as puesto'
                )
                ->where('part.id', $id_part)
                ->first();

            $membrete = DB::table('colab_planillera_membretes')
                ->select('nombre_memb', 'apartado', 'email', 'tel')
                ->where('id_planillera', $sel_cia)->first();

            // 1. Guardar o actualizar la carta (guardo salario en letras según tu lógica)
            $carta = Usr_partici_cartaofl::updateOrCreate(
                ['id_participante' => $id_part, 'id_ofl' => $id_oferta],
                [
                    'salario' => $salario,
                    'finicio' => $finicio,
                    'fterminacion' => $fterminacion,
                    'sel_tipo_contrato' => $tipo_contrato,
                    'sel_tipo_salario' => $tipo_salario,
                    'cod_cia' => $sel_cia,
                    'cod_ceco' => $sel_ceco,
                    'id_user_firmante' =>$sel_firmante,
                    'generada_por' => Auth::user()->email,
                    'plazo_nombramiento' => $txt_plazo_nombramiento,
                ]
            );

            // 2. Guardar los beneficios
            Usr_partici_cartabeneficios::where('id_carta_ofl', $carta->id)->delete();

            $ids_creados = [];
            $ids_beneficio_list = [];

            if (!empty($data['beneficios'])) {
                foreach ($data['beneficios'] as $beneficio) {
                    $nuevo = Usr_partici_cartabeneficios::create([
                        'id_carta_ofl' => $carta->id,
                        'id_beneficio' => $beneficio['idBeneficio'],
                        'beneficio'    => $beneficio['nombre'],
                        'monto'        => $beneficio['monto'],
                        'tipo'         => $beneficio['tipo'],
                    ]);
                    $ids_creados[] = $nuevo->id;
                    $ids_beneficio_list[] = $beneficio['idBeneficio'];
                }
            }

            $texto_beneficios = [];

            if (!empty($ids_beneficio_list)) {
                $textos = Usr_partici_list_beneficios::whereIn('id', $ids_beneficio_list)->get();

                foreach ($textos as $t) {
                    $monto = null;
                    foreach ($data['beneficios'] as $b) {
                        if ($b['idBeneficio'] == $t->id) {
                            $monto = $b['monto'];
                            break;
                        }
                    }

                    // Si es tipo dinero y monto es numérico, convertir; si no, usar tal cual
                    $texto="";
                    
                    if ($t->tipo_dato === 'dinero' && is_numeric($monto)) {
                        $reemplazo = $this->numeroALetras($monto);
                        $texto=str_replace('[valor]', '<strong>'.$reemplazo.'</strong>', $t->texto);
                        $monto_para_array = number_format($monto, 2, '.', ',');
                    } else {
                        if ($t->tipo_dato === 'numerico' && is_numeric($monto)) {
                            $valor=$monto;
                        if($valor>1)
                        {   $texto=str_replace('[valor] veces', '<strong>'.$valor.'</strong> veces', $t->texto);}
                        else
                        {   $texto=str_replace('[valor] veces', '<strong>'.$valor.'</strong> vez', $t->texto);}
                            $monto_para_array = number_format($monto, 2, '.', ',');
                        } else {
                            $reemplazo = $monto ?? '';
                            $texto=str_replace('[valor]', '<strong>'.$reemplazo.'</strong>', $t->texto);
                            $monto_para_array = $monto;
                        }
                    }

                    $texto_beneficios[] = [
                        'text' => $texto,
                        'tipo_dato' => $t->tipo ?? null,
                        'tipo' => $t->tipo ?? null,
                        'monto' => $monto_para_array,
                    ];
                }
            }

            // 3. busca firmante
            $data_firmante = DB::table('users as u')
                ->select([
                    'u.id',
                    'm.prinombre',
                    'm.priapellido',
                    'p.descpue as cargo'
                ])
                ->leftJoin('m_empleados as m', 'm.id', '=', 'u.codigo')
                ->leftJoin('posiciones as p', 'p.id', '=', 'm.id_posicion')
                ->where('u.estatus', 1)
                ->where('u.firma_cartaoferta', 1)
                ->where('u.id', $sel_firmante)
                ->first();

            $nombre_formateado = $this->capitalizarNombre($data_firmante->prinombre) . ' ' . $this->capitalizarNombre($data_firmante->priapellido);
            $data_firmante->nombre = $this->nombreConExcepciones($nombre_formateado);

            // 4. Generar el PDF
            $datosPdf = [
                'prinombre' => $candidato->prinombre,
                'segnombre' => $candidato->segnombre ?? '',
                'priapellido' => $candidato->priapellido,
                'segapellido' => $candidato->segapellido ?? '',
                'genero' => $candidato->genero,
                'sr' => $candidato->genero == 'F' ? 'Estimada Sra.' : 'Estimado Sr.',
                'num_doc' => $candidato->num_doc,
                'puesto' => $candidato->puesto,
                'nombre_memb' => $membrete->nombre_memb ?? '',
                'apartado' => $data['apartado'] ?? '',
                'email' => $membrete->email ?? '',
                'tel' => $membrete->tel ?? '',
                'plazo_nombramiento' => $txt_plazo_nombramiento,
                'firmante'=>  $data_firmante->nombre,
                'puestofirmante'=> $data_firmante->cargo,
                'id_carta' => $carta->id,
                'fecha_actual' => Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
                'salario' => $this->numeroALetras($salario),
                'finicio' => $finicio,
                'fterminacion' => $fterminacion,
                'sel_tipo_salario' => $tipo_salario,
                'sel_tipo_contrato' => $tipo_contrato == 'T' ? 'definido de once (11) meses' : 'indefinido',
                'fecha_larga_inicio' => Carbon::parse($finicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
                'texto_beneficios' => $texto_beneficios ?? [],
            ];

            $pdf = Pdf::loadView('re.PDFcartaoferta', ['data' => $datosPdf]);

            $filename = 'carta_oferta_' . Str::slug($candidato->prinombre . '_' . $candidato->priapellido) . '_' . Str::random(6) . '.pdf';
            $path = 'cartas_oferta/' . $filename;

            Storage::disk('public')->put($path, $pdf->output());

            $urlPublica = asset('storage/' . $path);
           
            // Guardar la URL
            $carta->update(['url_carta_oferta' => $urlPublica]);
            DB::table('usr_participantes')->where('id', $id_part)->update(['id_etapa' => 8]);

            $data_cartas_ofertas= DB::table('usr_partici_cartaofl')
            ->where('id_participante', $id_part)
            ->where('id_ofl', $id_oferta )
            ->select('id', 'finicio', 'salario', 'sel_tipo_salario',  'sel_tipo_contrato','sel_tipo_salario', 'url_carta_oferta','generada_por', 'estado', 'aceptacion_ofl','faceptacion',
                DB::raw("DATE_FORMAT(finicio, '%d-%m-%Y') as finicio_formateado"),
                DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as fecha_registro"))
            ->first();

            DB::commit();

            return response()->json([
                'success' => true,
                'url_pdf' => $urlPublica,
                'id_carta' => $carta->id,
                'cartas_ofertas' => $data_cartas_ofertas,
                'message' => 'Carta de oferta generada exitosamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    private function numeroALetras($numero)
    {
        $numero = floatval($numero);
        $signo = $numero < 0 ? 'menos ' : '';
        $numero = abs($numero);

        // Separar entero y decimal
        $partes = explode('.', number_format($numero, 2, '.', ''));
        $entero = intval($partes[0]);
        $decimal = intval($partes[1]);

        if (extension_loaded('intl')) {
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $letras = $formatter->format($entero);
            $letras = preg_replace('/\s+/', ' ', $letras);
            $letras = ucfirst(trim($letras));

            $resultado = "{$signo}{$letras} dólares con " . str_pad($decimal, 2, '0', STR_PAD_LEFT) . "/100";
            $resultado .= " (B/." . number_format($numero, 2, '.', ',') . ")";

            return $resultado;
        }

        // Fallback si intl no está disponible
        return "<strong>{$signo}" . number_format($numero, 2, '.', ',') . " (sin convertir a letras)</strong>";
    }

    private function capitalizarNombre($nombre)
    {
        return mb_convert_case(trim($nombre), MB_CASE_TITLE, "UTF-8");
    }

    private function nombreConExcepciones($nombre)
    {
        $minusculas = ['de', 'del', 'la', 'las', 'los', 'y'];
        $partes = preg_split('/\s+/', mb_strtolower($nombre));
        $capitalizado = [];
        foreach ($partes as $palabra) {
            $capitalizado[] = in_array($palabra, $minusculas) ? $palabra : mb_convert_case($palabra, MB_CASE_TITLE, "UTF-8");
        }
        return implode(' ', $capitalizado);
    }

    public function editcartaoferta(Ofertas $ofertas)
    {
        if (isset(Auth::user()->id)) 
        {
            $data= request()->except('_token');
            $id_carta = $data['id_carta'];
            $carta = Usr_partici_cartaofl::find($id_carta);
            $beneficios = Usr_partici_cartabeneficios::where('id_carta_ofl', $id_carta)->get();

            if ($carta) {
                return response()->json([
                    'success' => true,
                    'carta' => $carta,
                    'beneficios' => $beneficios,
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Carta no encontrada.'], 404);
            }
        } else {
            return view('auth.login');
        }
    }

    public function cartapdf(Ofertas $ofertas)
    {
       
        if (isset(Auth::user()->id)) 
        {
            $data= request();
            if($data['opt']==0)
            {
                setlocale(LC_ALL, 'es_ES');
                $txtid= $data['txtid']; 
                
                $data_ofertas= DB::select("SELECT cart.salario, cart.finicio, cart.fterminacion, cart.sel_tipo_contrato, cart.sel_tipo_salario
                ,pla.nombre_memb, pla.apartado, pla.email, pla.tel,
                curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.genero,
                pos.descpue
                FROM usr_partici_cartaofl cart 
                LEFT JOIN usr_participantes parti ON (parti.id= cart.id_participante)
                LEFT JOIN vacantes_solicitudes ofl ON (ofl.id=parti.id_ofl)
                LEFT JOIN colab_planillera_membretes pla ON (pla.id_planillera=ofl.COD_PAGADORA)
                LEFT JOIN usr_part_curriculum curri ON (curri.id=parti.id_part_curriculum)
                LEFT JOIN posiciones pos ON (pos.id=parti.id_puesto)
                WHERE cart.id=$txtid and cart.estado");

                //var_dump($data_ofertas);
                foreach ($data_ofertas as $r)
                {   $finicio= $r->finicio;
                    $salario= $r->salario;
                    $fterminacion= $r->fterminacion;
                    $sel_tipo_contrato= $r->sel_tipo_contrato;
                    $segnombre=" ";$segapellido=" ";
                    $estimado='Estimado';
                    $sr='Señor';
                    if($r->genero=='F')
                    {   $estimado='Estimada';
                        $sr='Señora';}

                    $nombre_memb= $r->nombre_memb;
                    $apartado= $r->apartado;
                    $email= $r->email;
                    $tel= $r->tel;

                    $prinombre= $r->prinombre;
                    if($r->segnombre!=null)
                    {   $segnombre= $r->segnombre;}
                    
                    $priapellido= $r->priapellido;
                    if($r->segapellido!=null)
                    {   $segapellido= $r->segapellido;}
                
                    $genero= $r->genero;
                    $descpue= $r->descpue;
                }                  
            
                $fecha_actual = \Carbon\Carbon::now()->isoFormat(' D \d\e MMMM \d\e\l Y');
                $fecha_larga_inicio = \Carbon\Carbon::parse($finicio)->isoFormat('dddd D \d\e MMMM \d\e\l Y');

                DB::table('usr_partici_cartaofl')->where('id','=', $txtid)->update(['estado' => 5]);

                $data=json_encode(array(
                    "nombre_memb"=>$nombre_memb,
                    "apartado"=>$apartado,
                    "email"=>$email,                
                    "tel"=>$tel,
                    "fecha_actual"=>$fecha_actual,
                    "sr"=>$sr,
                    "estimado"=>$estimado,
                    "descpue"=>$descpue,
                    "prinombre"=>$prinombre,
                    "segnombre"=>$segnombre,
                    "priapellido"=>$priapellido,
                    "segapellido"=>$segapellido,
                    "salario"=>$salario,
                    "finicio"=>$finicio,
                    "fterminacion"=>$fterminacion,
                    "firmante"=>Auth::user()->name,
                    "puestofirmante"=>Auth::user()->puesto,
                    "emailfirmante"=>Auth::user()->email,
                    "sel_tipo_contrato"=>$sel_tipo_contrato,
                    "fecha_larga_inicio"=>$fecha_larga_inicio,
                ));

                $pdf = Pdf::loadView('re.PDFcartaoferta',compact('data')); 
                return $pdf->download('Carta Oferta '.$descpue.'.pdf');
            }else{echo $data['opt'];}
        }
        else{   return view('auth.login');}
    }

    public function cartapdfcontrato(Ofertas $ofertas)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request();            
            if($data['opt_cont']==0)
            {
                $id_participante=$data['id_participante_cont'];
                $id_curri=$data['id_curri_cont'];
                $data_ofertas= DB::select("SELECT cart.salario, cart.finicio, cart.fterminacion, cart.sel_tipo_contrato, cart.sel_tipo_salario,
                pla.nombre_memb, pla.apartado, pla.email, pla.tel, pla.detalle, pla.representante, pla.det_representante, pla.ced_representante,
                curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.genero, nac.nacionalidad, curri.direccion, curri.f_nacimiento, curri.id_tipo_doc_letra, curri.num_doc, curri.num_ss, curri.estadocivil,
                prov.provincia, distri.distrito, correg.corregimiento,
                pos.descpue,descri.proposito, est.hrs_semanales,  est.hrs_mensuales, est.horarios
                FROM usr_participantes parti
                LEFT JOIN usr_partici_cartaofl cart  ON (parti.id= cart.id_participante and cart.estado=3)
                LEFT JOIN vacantes_solicitudes ofl ON (ofl.id=parti.id_ofl)
                LEFT JOIN colab_planillera_membretes pla ON (pla.id_planillera=ofl.COD_PAGADORA)
                LEFT JOIN usr_part_curriculum curri ON (curri.id=parti.id_part_curriculum)
                LEFT JOIN posiciones pos ON (pos.id=parti.id_puesto)
                LEFT JOIN usr_nacionalidad nac ON (nac.id=curri.id_nacionalidad)
                LEFT JOIN dir_provincias prov ON (prov.id=curri.id_provincia)
                LEFT JOIN dir_distritos distri ON (distri.id=curri.id_distrito)
                LEFT JOIN dir_corregimientos correg ON (correg.id=curri.id_corregimiento)
                LEFT JOIN descriptivos descri ON (descri.id=pos.iddf)
                LEFT JOIN estructuras est ON (est.id=pos.idue)
                WHERE parti.id=$id_participante and parti.id_part_curriculum=$id_curri");

                foreach ($data_ofertas as $r)
                {   $finicio= $r->finicio;
                    $salario= $r->salario;
                    $fterminacion= $r->fterminacion;
                    $sel_tipo_salario = $r->sel_tipo_salario;
                    $num_ss = $r->num_ss;
                    $estadocivil = $r->estadocivil;
                    
                    $tipo_contrato='-';
                    $sel_tipo_contrato= $r->sel_tipo_contrato;
                    if($sel_tipo_contrato=='T') { $tipo_contrato="DEFINIDO";}
                    if($sel_tipo_contrato=='P') { $tipo_contrato="INDEFINIDO";}

                    $segnombre=" ";$segapellido=" ";
                    $estimado='Estimado';
                    $sr='Señor';
                    $masc_fem='masculino';
                    if($r->genero=='F')
                    {   $estimado='Estimada';
                        $sr='Señora';
                        $masc_fem="femenino";}
                    $nacionalidad= $r->nacionalidad;                  

                    $anios=\Carbon\Carbon::parse($r->f_nacimiento)->age;

                    $nombre_memb= $r->nombre_memb;
                    $representante= $r->representante;
                    $ced_representante= $r->ced_representante;
                    $det_representante= $r->det_representante;
                    $apartado= $r->apartado;
                    $detalle= $r->detalle;

                    $prinombre= $r->prinombre;
                    if($r->segnombre!=null)
                    {   $segnombre= $r->segnombre;}
                    
                    $priapellido= $r->priapellido;
                    if($r->segapellido!=null)
                    {   $segapellido= $r->segapellido;}
                
                    $direccion= $r->direccion;
                    $provincia= $r->provincia;
                    $distrito= $r->distrito;
                    $corregimiento= $r->corregimiento;
                    $genero= $r->genero;
                    $tipo_doc_firma='';
                    if($r->id_tipo_doc_letra='C')
                    {   $tipo_doc='de la cédula de identidad personal  No.'.$r->num_doc;
                        $tipo_doc_firma='Cédula No. '.$r->num_doc;}
                    if($r->id_tipo_doc_letra='P')
                    {   $tipo_doc='del pasaporte No. '.$r->num_doc;
                        $tipo_doc_firma='Pasaporte No. '.$r->num_doc;}
                    
                    $descpue= $r->descpue;
                    $proposito=$r->proposito;
                    $hrs_semanales=$r->hrs_semanales; 
                    $hrs_mensuales=$r->hrs_mensuales; 
                    $horarios=$r->horarios;
                }                  

                $data_dependientes= DB::select("SELECT id, nombre, parentesco, f_nacimiento
                FROM usr_part_dependientes         
                WHERE id_part_curriculum=$id_curri");
            
                $fecha_actual = \Carbon\Carbon::now()->isoFormat(' D \d\í\a\s \d\e\l\ \m\e\s\ \d\e MMMM \d\e\l Y');
                $fecha_larga_inicio = \Carbon\Carbon::parse($finicio)->isoFormat('dddd D \d\e MMMM \d\e\l Y');
                $fecha_larga_terminacion =$fterminacion;
                if($fterminacion!='1900-01-01'&&$sel_tipo_contrato!='P')
                {   $fecha_larga_terminacion = \Carbon\Carbon::parse($fterminacion)->isoFormat('dddd D \d\e MMMM \d\e\l Y');}

                $data=json_encode(array(
                    "nombre_memb"=>$nombre_memb,
                    
                    "representante"=>$representante,
                    "ced_representante"=>$ced_representante,
                    "det_representante"=> $det_representante,
                    "detalle"=> $detalle,
                    "apartado"=>$apartado,

                    "fecha_actual"=>$fecha_actual,
                    "sr"=>$sr,
                    "estimado"=>$estimado,
                    "descpue"=>$descpue,
                    "proposito"=>$proposito,
                    "prinombre"=>$prinombre,
                    "segnombre"=>$segnombre,
                    "priapellido"=>$priapellido,
                    "segapellido"=>$segapellido,
                    "masc_fem"=> $masc_fem,
                    "nacionalidad"=> $nacionalidad,
                    "anios"=>$anios,

                    "direccion"=>$direccion,
                    "provincia"=> $provincia,
                    "distrito"=> $distrito,
                    "corregimiento"=> $corregimiento,
                    "tipo_doc"=>$tipo_doc,
                    "num_ss" => $num_ss,
                    "estadocivil" => $estadocivil,
                    "tipo_doc_firma"=>$tipo_doc_firma,
                    "salario"=>$salario,
                    "sel_tipo_salario" => $sel_tipo_salario,
                    "finicio"=>$finicio,
                    "fterminacion"=>$fterminacion,
                    "firmante"=>Auth::user()->name,
                    "puestofirmante"=>Auth::user()->puesto,
                    "emailfirmante"=>Auth::user()->email,
                    
                    "sel_tipo_contrato"=>$sel_tipo_contrato,
                    "tipo_contrato"=>$tipo_contrato,
                    "fecha_larga_inicio"=>$fecha_larga_inicio,
                    "fecha_larga_terminacion" =>$fecha_larga_terminacion,
                    "dependientes"=>$data_dependientes,
                    "hrs_semanales"=> $hrs_semanales,
                    "hrs_mensuales"=> $hrs_mensuales, 
                    "horarios"=> $horarios,
                ));

                $pdf = Pdf::loadView('re.PDFcontwork',compact('data')); 
                return $pdf->download('Contrato '.$prinombre." ".$segnombre." ".$priapellido." ".$segapellido.'.pdf');
            }
        }
        else{   return view('auth.login');}
    }

    public function tempUploadCartaOferta(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:2048', // solo PDF y máx 2MB
        ]);

        $file = $request->file('pdf_file');
        $filename = 'temp_carta_' . Str::uuid() . '.pdf';
        $path = $file->storeAs('temp_cartas_oferta', $filename, 'public');

        return response()->json([
            'filename' => $filename,
            'url_temp' => asset('storage/' . $path)
        ]);
    }

    public function saveCartaOfertaFinal(Request $request)
    {
        $filename = $request->input('filename');
        $id_cartaofl = $request->input('id_cartaofl');
        $id_part = $request->input('id_part');

        if (!$filename || !$id_cartaofl) {
            return response()->json(['message' => 'Datos incompletos.'], 400);
        }

        $tempPath = 'temp_cartas_oferta/' . $filename;

        if (!Storage::disk('public')->exists($tempPath)) {
            return response()->json(['message' => 'Archivo temporal no encontrado.'], 404);
        }

        $newFilename = 'carta_oferta_' . $id_cartaofl . '_' . now()->format('YmdHis') . '.pdf';
        $finalPath = 'cartas_firmadas/' . $newFilename;
        
        Storage::disk('public')->move($tempPath, $finalPath);

        // Generar la URL completa (con dominio)
        $url = asset('storage/' . $finalPath);

        DB::table('usr_partici_cartaofl')
            ->where('id', $id_cartaofl)
            ->update([
                'aceptacion_ofl' => $url,
                'faceptacion' => now(),
                'estado' => 3
            ]);

        DB::table('usr_participantes')
            ->where('id', $id_part)
            ->update(['id_etapa' => 8]);

        $id_oferta = DB::table('usr_participantes')
        ->where('id', $id_part)
        ->value('id_ofl');

        $data_cartas_ofertas= DB::table('usr_partici_cartaofl')
            ->where('id_participante', $id_part)
            ->where('id_ofl', $id_oferta )
            ->select('id', 'finicio', 'salario', 'sel_tipo_salario',  'sel_tipo_contrato','sel_tipo_salario', 'url_carta_oferta','generada_por', 'estado', 'aceptacion_ofl','faceptacion',
                DB::raw("DATE_FORMAT(finicio, '%d-%m-%Y') as finicio_formateado"),
                DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as fecha_registro"))
            ->first();

        return response()->json([
            'message' => 'Carta guardada correctamente.',
            'cartas_ofertas' => $data_cartas_ofertas
        ]);
    }

    public function validaPaseFirma(Request $request)
    {
        $data= request()->except('_token');
        $id_carta = $data['id_cartaoflacept'];

        $CartaOfertaFirmada = DB::table('usr_partici_cartaofl as c')
            ->leftJoin('vacantes_solicitudes as ofl', 'ofl.id', '=', 'c.id_ofl')
            ->leftJoin('posiciones as p', 'p.id', '=', 'ofl.id_puesto')
            ->leftJoin('estructuras as e', 'e.id', '=', 'p.idue')
            ->leftJoin('usr_participantes as part', 'part.id', '=', 'c.id_participante')
            ->leftJoin('usr_part_curriculum as cv', 'cv.id', '=', 'part.id_part_curriculum')
            ->leftJoin('usr_nacionalidad as n', 'n.id', '=', 'cv.id_nacionalidad')
            ->leftJoin('pruebas_veritas as v', 'v.curriculum_id', '=', 'cv.id')
            ->where('c.id', $id_carta)
            ->where('c.estado', 3)
            ->selectRaw("
                c.id,
                c.salario,
                c.finicio,
                c.fterminacion,
                c.sel_tipo_contrato,
                IF(c.sel_tipo_contrato = 'P', 'Indefinido', 'Definido') as tipo_contrato,
                c.sel_tipo_salario,
                IF(c.sel_tipo_salario = 'B', 'Base', 'Por hora') as tipo_salario,
                c.cod_cia,
                c.cod_ceco,
                p.descpue as puesto,
                e.nameund as unidad,
                cv.id as id_curri,
                cv.genero,
                cv.num_doc,
                cv.num_ss,
                cv.nacio_extran,
                cv.permiso_trab,
                cv.permiso_doc,
                IF(v.puntaje = 1, 'Elegible', IF(v.puntaje = 2,'Elegible/Revisar','No Elegible')) as veritas,
                CONCAT(UPPER(LEFT(n.nacionalidad, 1)), LOWER(SUBSTRING(n.nacionalidad, 2))) AS nacionalidad,
                DATE_FORMAT(c.finicio, '%d-%m-%Y') as finicio_format,
                DATE_FORMAT(c.fterminacion, '%d-%m-%Y') as fterminacion_format,
                DATE_FORMAT(c.created_at, '%d-%m-%Y') as fecha_registro
            ")
            ->first();


            $BeneficiosFirmada = DB::table('usr_partici_cartabeneficios as b')
            ->leftJoin('usr_partici_list_beneficios as l', 'l.id', '=', 'b.id_beneficio')
            ->select('l.beneficio','l.tipo_dato','l.tipo','b.monto')
            ->where('b.id_carta_ofl', $id_carta)
            ->orderBy('l.orden', 'ASC')
            ->get();

            $documentosFirma = DB::table('usr_part_curri_tipodocattach as ld')
            ->leftJoin('usr_part_curri_docattach as b', function($join) use ($CartaOfertaFirmada) {
                $join->on('ld.id', '=', 'b.iddoc')
                    ->where('b.id_curri', '=', $CartaOfertaFirmada->id_curri);
            })
            ->select('ld.id', 'ld.nomdoc', 'b.downdoc')
            ->get();

            
       

        return response()->json([
            'message' => 'Carta guardada correctamente.',
            'carta_oferta' => $CartaOfertaFirmada,
            'beneficios'=> $BeneficiosFirmada,
            'documentosFirma'=>$documentosFirma
        ]);
        
    }

    public function subirfoto(Request $request)
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        if ($request->isMethod('POST')) {
            $num_aprob_ofl = intval($request->input('num_aprob_ofl'));
            $data = $request->input('image');

            if (!$data || strpos($data, 'base64,') === false) {
                return response()->json(['error' => 'Formato de imagen inválido'], 400);
            }

            // Extraer base64 y decodificar
            [$meta, $base64data] = explode(',', $data);
            $binaryImage = base64_decode($base64data);

            // Actualizar en base de datos
            DB::table('usr_part_curriculum')
                ->where('id', $num_aprob_ofl)
                ->update(['photo' => $binaryImage]);

            // Obtener imagen guardada
            $photoData = DB::table('usr_part_curriculum')
                ->where('id', $num_aprob_ofl)
                ->value('photo');

            // Devolver HTML con la imagen
            return response()->make(
                '<img src="data:image/png;base64,' . base64_encode($photoData) . '" class="rounded-circle" id="img_photo" />',
                200,
                ['Content-Type' => 'text/html']
            );
        }

        return response()->json(['error' => 'Método inválido'], 405);
    }


    public function sendfirmaContrato(Request $request)
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        $data= request()->except('_token');
        $id_carta = $data['id_cartaoflacept'];
        $carta_presentacion = $data['carta_presentacion'];          
        $id_ofl = $data['id_ofl'];               
        $id_curri = $data['id_curri'];
        $id_part = $data['id_part'];
        $marcacion = $data['marcacion'];
        $sel_cia_firma = $data['sel_cia_firma'];
        $sel_ceco_firma = $data['sel_ceco_firma'];

          $salario = DB::table('usr_partici_cartaofl')                
                ->where('id', $id_carta)
                ->select('salario')
                ->first();

            // Actualizar en base de datos
            DB::table('usr_participantes')
            ->where('id', $id_part)
            ->update([
                'marcacion' => $marcacion,
                'aspiracion_sal' => $salario->salario,
                'id_etapa' => 9]);

            DB::table('usr_partici_cartaofl')
            ->where('id', $id_carta)
            ->update([
                'carta_presentacion' => $carta_presentacion,
                'estado' => 4,
                'cod_cia' => $sel_cia_firma,
                'cod_ceco' => $sel_ceco_firma]);
            
            
            $data_cartas_ofertas = DB::table('usr_partici_cartaofl')
                ->where('id_participante', $id_part)
                ->where('id_ofl', $id_ofl)
                ->select(
                'id', 'finicio', 'salario', 'sel_tipo_salario', 'sel_tipo_contrato', 
                'sel_tipo_salario', 'url_carta_oferta', 'generada_por', 'estado', 
                'aceptacion_ofl', 'faceptacion',
                DB::raw("DATE_FORMAT(finicio, '%d-%m-%Y') as finicio_formateado"),
                DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as fecha_registro")
                )
                ->first();

        // Puedes retornar algo si es AJAX
        return response()->json([
            'success' => true,
            'message' => 'EL Candidato ha pasado a firma de contrato.',
            'cartas_ofertas' => $data_cartas_ofertas
        ]);
    }
}