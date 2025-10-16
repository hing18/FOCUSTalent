<?php

namespace App\Http\Controllers\rl;

use App\Http\Controllers\Controller;
use App\Models\me\m_empleados;
use App\Models\re\usr_participantes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluacionReclutamientoMail;
use Illuminate\Support\Facades\Log;

class ContworkController extends Controller
{


    public function index()
    {
        $id_menu = 18;
        $id_menu_sup = 17;

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data_parti = usr_participantes::query()
            ->leftJoin('usr_part_curriculum as curri', 'curri.id', '=', 'usr_participantes.id_part_curriculum')
            ->leftJoin('usr_nacionalidad as nac', 'nac.id', '=', 'curri.id_nacionalidad')
            ->leftJoin('posiciones as pos', 'pos.id', '=', 'usr_participantes.id_puesto')
            ->leftJoin('estructuras as est', 'est.id', '=', 'pos.idue')
            ->leftJoin('usr_partici_cartaofl as carta', 'carta.id_participante', '=', 'usr_participantes.id')
            ->leftJoin('m_empleados as m', 'm.email', '=', 'carta.generada_por')
            ->leftJoin('vacantes_solicitudes as vac', 'vac.id','=', 'carta.id_ofl')
            ->where('usr_participantes.id_etapa', 9)
            ->where('vac.id_estatus',"<", 4)
            ->select(
                'carta.id as id_carta',
                'carta.id_participante',
                'carta.id_ofl',
                'curri.id as id_curri',
                'curri.prinombre',
                'curri.priapellido',
                'curri.num_doc',
                'curri.foto',
                'curri.email',
                'curri.tel', 
                'curri.color_text',
                'curri.color_bg',
                'nac.nacionalidad',
                'pos.descpue',
                'est.nameund',
                'carta.finicio',
                'm.prinombre as nombre_reclutador',
                'm.priapellido as apellido_reclutador',
                DB::raw("DATE_FORMAT(carta.finicio, '%d-%m-%Y') as finicio_formateado")
            )->get();

        return view('rl.contwork', compact('id_menu', 'id_menu_sup', 'data_parti'));
    }

    public function porcontrato(Request $request)
    {   
        if (!isset(Auth::user()->id)) {
            return back()->with('error', 'No autorizado');
        }

        $data_parti = usr_participantes::query()
            ->leftJoin('usr_part_curriculum as curri', 'curri.id', '=', 'usr_participantes.id_part_curriculum')
            ->leftJoin('usr_nacionalidad as nac', 'nac.id', '=', 'curri.id_nacionalidad')
            ->leftJoin('posiciones as pos', 'pos.id', '=', 'usr_participantes.id_puesto')
            ->leftJoin('estructuras as est', 'est.id', '=', 'pos.idue')
            ->leftJoin('usr_partici_cartaofl as carta', 'carta.id_participante', '=', 'usr_participantes.id')
            ->leftJoin('m_empleados as m', 'm.email', '=', 'carta.generada_por')
            ->where('usr_participantes.id_etapa', 9)
            ->select(
                'carta.id as id_carta',
                'carta.id_participante',
                'carta.id_ofl',
                'curri.id as id_curri',
                'curri.prinombre',
                'curri.priapellido',
                'curri.num_doc',
                'curri.foto',
                'curri.email',
                'curri.tel', 
                'curri.color_text',
                'curri.color_bg',
                'nac.nacionalidad',
                'pos.descpue',
                'est.nameund',
                'carta.finicio',
                'm.prinombre as nombre_reclutador',
                'm.priapellido as apellido_reclutador',
                DB::raw("DATE_FORMAT(carta.finicio, '%d-%m-%Y') as finicio_formateado")
            )->get();
            
        return response()->json([
            'success' => true,
            'data_parti' => $data_parti
        ]);
    }

    public function contratoPdf(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 401);
        }

        $id_carta = $request->input('id_carta');

        // ==== Consulta base (recorta o reemplaza por la tuya) ====
        $data = DB::table('usr_partici_cartaofl as cart')
            ->leftJoin('usr_participantes as part', 'part.id', '=', 'cart.id_participante')
            ->leftJoin('posiciones as pos', 'pos.id', '=', 'part.id_puesto')
            ->leftJoin('estructuras as est', 'est.id', '=', 'pos.iduni')
            ->leftJoin('colab_planillera_ceco as cia', function($join) {
                $join->on('cia.COD_PAGADORA', '=', 'cart.cod_cia')
                     ->on('cia.COD_CIA', '=', 'cart.cod_ceco');
            })
            ->leftJoin('colab_planillera_membretes as pla', 'pla.id_planillera', '=', 'cia.cod_pagadora')
            ->leftJoin('usr_part_curriculum as curri', 'curri.id', '=', 'part.id_part_curriculum')
            ->leftJoin('usr_nacionalidad as nac', 'nac.id', '=', 'curri.id_nacionalidad')
            ->leftJoin('descriptivos as df', 'df.id', '=', 'pos.iddf')
            ->leftJoin('dir_provincias as prov', 'prov.id', '=', 'curri.id_provincia')
            ->leftJoin('dir_distritos as dist', 'dist.id', '=', 'curri.id_distrito')
            ->leftJoin('dir_corregimientos as corr', 'corr.id', '=', 'curri.id_corregimiento')
            ->where('cart.estado', 4)
            ->where('cart.id', $id_carta)
            ->selectRaw("
                CONCAT(UPPER(LEFT(curri.prinombre, 1)), LOWER(SUBSTRING(curri.prinombre, 2))) AS prinombre,
                CONCAT(UPPER(LEFT(curri.segnombre, 1)), LOWER(SUBSTRING(curri.segnombre, 2))) AS segnombre,
                CONCAT(UPPER(LEFT(curri.priapellido, 1)), LOWER(SUBSTRING(curri.priapellido, 2))) AS priapellido,
                CONCAT(UPPER(LEFT(curri.segapellido, 1)), LOWER(SUBSTRING(curri.segapellido, 2))) AS segapellido,
                curri.genero, curri.num_doc, curri.num_ss, curri.id_tipo_doc_letra,
                curri.estadocivil, curri.tel, curri.email,
                DATE_FORMAT(curri.f_nacimiento, '%Y-%m-%d') as f_nacimiento, 
                curri.permiso_trab, curri.permiso_doc, curri.direccion, curri.cv_doc, curri.foto,
                curri.id as id_curri,
                curri.contacto_urgencia, curri.parentesco_urgencia, curri.tel_urgencia,
                CONCAT(UPPER(LEFT(nac.nacionalidad, 1)), LOWER(SUBSTRING(nac.nacionalidad, 2))) AS nacionalidad,
                prov.provincia, dist.distrito, corr.corregimiento,
                cart.id as id_carta, cart.salario, cart.finicio, cart.fterminacion,
                cart.sel_tipo_contrato, cart.sel_tipo_salario,
                cart.id_participante as id_part, cart.aceptacion_ofl as doc_cofl, cart.cod_cia, cart.cod_ceco, cart.carta_presentacion,
                part.marcacion,
                pos.descpue, est.nameund as unidad, est.hrs_mensuales, est.hrs_semanales, est.horarios,
                cia.PAGADORA as cia, cia.NOM_CIA as ceco,
                pla.nombre_memb, pla.detalle, pla.det_representante, pla.representante, pla.ced_representante,
                df.proposito
            ")
            ->first();

        if (!$data) {
           
            return response()->json([
                'success' => false,
                'message' => 'Carta no encontrada'
            ], 401);
        }

        // ==== Dependientes ====
        $dependientes = DB::table('usr_part_dependientes as d')
        ->where('d.id_curri', $data->id_curri)
        ->selectRaw("d.nombre, d.parentesco, DATE_FORMAT(d.f_nacimiento, '%d-%m-%Y') as f_nacimiento")
        ->get();

        // ==== Preparación de campos derivados ====
        Carbon::setLocale('es');
        $fechaAhora = Carbon::now()->isoFormat('D [días del mes de] MMMM [del] Y'); // tu formato inline

        $finicio = Carbon::parse($data->finicio);
        $fterminacion = $data->fterminacion && $data->fterminacion !== null ? Carbon::parse($data->fterminacion) : null;

        $payload = [
            'fecha_actual'         => $fechaAhora,
            'nombre_memb'          => $data->nombre_memb,
            'representante'        => $data->representante,
            'ced_representante'    => $data->ced_representante,
            'det_representante'    => $data->det_representante,
            'detalle'              => $data->detalle,

            'prinombre'            => $data->prinombre ?? '',
            'segnombre'            => $data->segnombre ?? '',
            'priapellido'          => $data->priapellido ?? '',
            'segapellido'          => $data->segapellido ?? '',

            'masc_fem'             => $data->genero === 'F' ? 'femenino' : 'masculino',
            'nacionalidad'         => $data->nacionalidad,
            'direccion'            => $data->direccion,
            'provincia'            => $data->provincia,
            'distrito'             => $data->distrito,
            'corregimiento'        => $data->corregimiento,

            // edad (exacta) desde f_nacimiento
            'anios'                => Carbon::parse($data->f_nacimiento)->age,

            // tipo doc para el texto y para firma
            'tipo_doc'             => ($data->id_tipo_doc_letra === 'P')
                                        ? 'del pasaporte No. '.$data->num_doc
                                        : 'de la cédula de identidad personal No. '.$data->num_doc,
            'tipo_doc_firma'       => ($data->id_tipo_doc_letra === 'P')
                                        ? 'Pasaporte No. '.$data->num_doc
                                        : 'Cédula No. '.$data->num_doc,

            'puesto'               => $data->descpue,
            'proposito'            => $data->proposito,

            'tipo_contrato'        => ($data->sel_tipo_contrato === 'T') ? 'DEFINIDO' : 'INDEFINIDO',
            'fecha_larga_inicio'   => $finicio->isoFormat('dddd D [de] MMMM [de] Y'),
            'fterminacion_largo'   => $fterminacion ? $fterminacion->isoFormat('dddd D [de] MMMM [de] Y') : '',
            'sel_tipo_contrato'    => $data->sel_tipo_contrato,

            'dependientes'         => $dependientes->map(function ($d) { return (array) $d;})->toArray(),

            'hrs_semanales'        => $data->hrs_semanales,
            'hrs_mensuales'        => $data->hrs_mensuales,
            'horarios'             => $data->horarios,
            'salario'              => $data->salario,
            'num_ss'               => $data->num_ss,
            'estadocivil'          => Str::ucfirst(Str::lower($data->estadocivil)),
            'sel_tipo_salario'     => $data->sel_tipo_salario
        ];

        // Estos 2 campos los usas así en tu Blade:
        // $sal se calcula dentro del Blade, pero también puedes precalcular aquí.
        // $fecha_larga_terminacion lo arma el Blade con condición.

        // ==== Render PDF ====
        // Importante: tu Blade espera UNA variable 'data' con un JSON.

        $pdf = Pdf::loadView('rl.PDFcontwork', ['data' => $payload])->setPaper('legal', 'portrait');

        $filename = 'contrato - ' . Str::slug($payload['prinombre'] . ' ' . $payload['priapellido']) . '.pdf';
        $path = 'contratos/' . $filename;

            Storage::disk('public')->put($path, $pdf->output());

        //return $pdf->download($urlPublica);
        // Si lo quieres en el navegador:
        // return $pdf->stream($fileName);


        Storage::disk('public')->put($path, $pdf->output());

        $urlPublica = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'url_pdf' => $urlPublica
        ]);

    }

    public function tempUploadContrato(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:2048', // solo PDF y máx 2MB
        ]);

        $file = $request->file('pdf_file');
        $filename = 'temp_contrato_firmado_' . Str::uuid() . '.pdf';
        $path = $file->storeAs('temp_contratos_firmados', $filename, 'public');

        return response()->json([
            'filename' => $filename,
            'url_temp' => asset('storage/' . $path)
        ]);
    }

    public function saveContratofirmado(Request $request)
    { 
        $filename = $request->input('filename');
        $id_carta = $request->input('id_carta');
        $id_curri = $request->input('id_curri');
        $id_part = $request->input('id_part');
        $id_puesto = $request->input('id_puesto');

        if (!$filename || !$id_carta || !$id_curri || !$id_part || !$id_puesto) {
            return response()->json(['message' => 'Datos incompletos.'], 400);
        }

        $tempPath = 'temp_contratos_firmados/' . $filename;
        $finalFilename = 'contrato_firmado_' . $id_carta . '_' . now()->format('YmdHis') . '.pdf';
        $finalPath = 'contratos_firmados/' . $finalFilename;

        if (!Storage::disk('public')->exists($tempPath)) {
            return response()->json(['message' => 'Archivo temporal no encontrado.'], 404);
        }

        $url = asset('storage/' . $finalPath);
        DB::beginTransaction();

        try {
            // Datos del currículum
            $datos = DB::table('usr_part_curriculum')
                ->where('id', $id_curri)
                ->select(
                    'prinombre','segnombre','priapellido','segapellido','foto','color_text','color_bg',
                    'genero','nacio_extran','f_nacimiento','id_nacionalidad','id_tipo_doc_letra','num_doc','num_ss',
                    'estadocivil','f_vencimiento','tel','email','id_provincia','id_distrito','id_corregimiento',
                    'direccion','discapacidad','detalle_descapacidad','cv_doc','permiso_trab','f_vence_permiso_trab',
                    'permiso_doc'
                )
                ->first();

            // Datos del contrato
            $datos_contrato = DB::table('usr_partici_cartaofl')
                ->where('id', $id_carta)
                ->select(
                    'salario','finicio','fterminacion',
                    'sel_tipo_contrato as tipo_contrato',
                    'sel_tipo_salario as tipo_salario','cod_cia','cod_ceco'
                )
                ->first();

            // Validación previa
            if (!$datos || !$datos_contrato) {
                throw new \Exception("No se pudo obtener información necesaria para continuar.");
            }

            // Obtener y actualizar numeración
            $numRegistro = DB::table('numera')
                ->where('id_numera', 'm_empleado')
                ->select('num')
                ->first();

            $nuevoNum = ($numRegistro->num ?? 0) + 1;

            // Actualizar carta de oferta
            DB::table('usr_partici_cartaofl')
                ->where('id', $id_carta)
                ->update([
                    'contworkfirmado' => $url,
                    'f_contworkfirmado' => now(),
                    'num_colab' => $nuevoNum,
                    'estado' => 5
                ]);

            // Actualizar etapa del participante
            DB::table('usr_participantes')
                ->where('id', $id_part)
                ->update(['id_etapa' => 10]);

            // Insertar nuevo empleado
            m_empleados::create([
                'id' => $nuevoNum,
                'prinombre' => $datos->prinombre,
                'segnombre' => $datos->segnombre,
                'priapellido' => $datos->priapellido,
                'segapellido' => $datos->segapellido,
                'foto' => $datos->foto,
                'color_text' => $datos->color_text,
                'color_bg' => $datos->color_bg,
                'genero' => $datos->genero,
                'nacio_extran' => $datos->nacio_extran,
                'f_nacimiento' => $datos->f_nacimiento,
                'id_nacionalidad' => $datos->id_nacionalidad,
                'id_tipo_doc_letra' => $datos->id_tipo_doc_letra,
                'num_doc' => $datos->num_doc,
                'num_ss' => $datos->num_ss,
                'estadocivil' => $datos->estadocivil,
                'f_vencimiento' => $datos->f_vencimiento,
                'tel' => $datos->tel,
                'email' => $datos->email,
                'id_provincia' => $datos->id_provincia,
                'id_distrito' => $datos->id_distrito,
                'id_corregimiento' => $datos->id_corregimiento,
                'direccion' => $datos->direccion,
                'discapacidad' => $datos->discapacidad,
                'detalle_descapacidad' => $datos->detalle_descapacidad,
                'cv_doc' => $datos->cv_doc,
                'permiso_trab' => $datos->permiso_trab,
                'f_vence_permiso_trab' => $datos->f_vence_permiso_trab,
                'permiso_doc' => $datos->permiso_doc,
                'salario' => $datos_contrato->salario,
                'finicio' => $datos_contrato->finicio,
                'fterminacion' => $datos_contrato->fterminacion,
                'tipo_contrato' => $datos_contrato->tipo_contrato,
                'tipo_salario' => $datos_contrato->tipo_salario,
                'id_posicion' => $id_puesto,
                'id_cia' => $datos_contrato->cod_cia,
                'id_ceco' => $datos_contrato->cod_ceco,
                'id_estatus' => 'A',
                'coef_intelectual' => 0,
                'niv_academico' => 0,
            ]);

            // Actualizar contador global
            DB::table('numera')
                ->where('id_numera', 'm_empleado')
                ->update(['num' => $nuevoNum]);

            // Actualizar estatus si ya se cubrieron los solicitados
            $id_ofl = DB::table('usr_participantes')
                ->where('id', $id_part)
                ->value('id_ofl');

            if ($id_ofl) {
                DB::table('vacantes_solicitudes')
                    ->where('id', $id_ofl)
                    ->increment('contratados');

                $conteo = DB::table('vacantes_solicitudes')
                    ->where('id', $id_ofl)
                    ->select('contratados', 'cantidad')
                    ->first();

                if ($conteo && $conteo->contratados >= $conteo->cantidad) {
                    DB::table('vacantes_solicitudes')
                        ->where('id', $id_ofl)
                        ->update(['id_estatus' => 5]);
                    

                    DB::table('usr_part_curriculum')
                        ->where('id', $id_curri)
                        ->update(['estado_registro' => 1]);                   

                    // Envia notificación  Evaluación
                    $email_jefes = DB::table('usr_part_curri_entrevistafun')
                    ->where('id_ofl', $id_ofl)
                    ->select('email_entrevistador')
                    ->groupBy('email_entrevistador')
                    ->pluck('email_entrevistador');

                    $empleados = DB::table('usr_participantes as part')
                        ->leftJoin('usr_part_curriculum as curri', 'curri.id', '=', 'part.id_ofl')
                        ->where('part.id_ofl', $id_ofl)
                        ->where('part.id_etapa', 9)
                        ->select(
                            DB::raw('CONCAT(UPPER(LEFT(curri.prinombre, 1)), LOWER(SUBSTRING(curri.prinombre, 2))) AS prinombre'),
                            DB::raw('CONCAT(UPPER(LEFT(curri.segnombre, 1)), LOWER(SUBSTRING(curri.segnombre, 2))) AS segnombre'),
                            DB::raw('CONCAT(UPPER(LEFT(curri.priapellido, 1)), LOWER(SUBSTRING(curri.priapellido, 2))) AS priapellido'),
                            DB::raw('CONCAT(UPPER(LEFT(curri.segapellido, 1)), LOWER(SUBSTRING(curri.segapellido, 2))) AS segapellido')
                        )
                        ->get();

                    $puesto = DB::table('posiciones')
                        ->where('id', $id_puesto)
                        ->value('descpue');

                    $token = Str::random(60);

                    foreach ($email_jefes as $email_jefe) {
                        // Generar token único y asegurarse que no exista en la tabla
                        do {
                            $token = Str::random(60);
                            $exists = DB::table('evaluacion_reclutamiento_tokens')->where('token', $token)->exists();
                        } while ($exists);

                        DB::table('evaluacion_reclutamiento_tokens')->insert([
                            'jefe_email' => $email_jefe,
                            'id_ofl'     => $id_ofl,
                            'token'      => $token,
                            'expires_at' => now()->addDays(7),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $url = url("/evaluacion-reclutamiento/$token");

                        try {
                            Mail::to($email_jefe)->send(new EvaluacionReclutamientoMail($empleados, $puesto, $url));
                        } catch (\Exception $e) {
                            Log::error("Error enviando email a $email_jefe: " . $e->getMessage());
                        }
                    }



                
                }
            }

            DB::commit();            
            Storage::disk('public')->move($tempPath, $finalPath);
            return response()->json([
                'success' => true,
                'message' => 'El candidato ha sido contratado exitosamente.',
                'code' => $nuevoNum,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el contrato.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request)
    {
        if (!isset(Auth::user()->id)) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }

        $data = $request->except('_token');
        $id_carta = $data['id_carta'];

        // Consulta principal
        $data_parti = DB::table('usr_partici_cartaofl as cart')
            ->leftJoin('usr_participantes as part', 'part.id', '=', 'cart.id_participante')
            ->leftJoin('posiciones as pos', 'pos.id', '=', 'part.id_puesto')
            ->leftJoin('estructuras as est', 'est.id', '=', 'pos.idue')
            ->leftJoin('colab_planillera_ceco as cia', function($join) {
                $join->on('cia.COD_PAGADORA', '=', 'cart.cod_cia')
                    ->on('cia.COD_CIA', '=', 'cart.cod_ceco');
            })
            ->leftJoin('usr_part_curriculum as curri', 'curri.id', '=', 'part.id_part_curriculum')
            ->leftJoin('usr_nacionalidad as nac', 'nac.id', '=', 'curri.id_nacionalidad')
            ->leftJoin('descriptivos as df', 'df.id', '=', 'pos.iddf')
            ->leftJoin('dir_provincias as prov', 'prov.id', '=', 'curri.id_provincia')
            ->leftJoin('dir_distritos as dist', 'dist.id', '=', 'curri.id_distrito')
            ->leftJoin('dir_corregimientos as corr', 'corr.id', '=', 'curri.id_corregimiento')
            ->leftJoin('vacantes_solicitudes as ofl', 'ofl.id', '=', 'cart.id_ofl')
            ->where('ofl.id_estatus','<',4)
            ->where('cart.id', $id_carta)
            ->select([
                DB::raw("CONCAT(UPPER(LEFT(curri.prinombre, 1)), LOWER(SUBSTRING(curri.prinombre, 2))) AS prinombre"),
                DB::raw("CONCAT(UPPER(LEFT(curri.segnombre, 1)), LOWER(SUBSTRING(curri.segnombre, 2))) AS segnombre"),
                DB::raw("CONCAT(UPPER(LEFT(curri.priapellido, 1)), LOWER(SUBSTRING(curri.priapellido, 2))) AS priapellido"),
                DB::raw("CONCAT(UPPER(LEFT(curri.segapellido, 1)), LOWER(SUBSTRING(curri.segapellido, 2))) AS segapellido"),
                'curri.genero',
                'curri.num_doc','curri.num_ss','curri.id_tipo_doc_letra',            
                'curri.estadocivil','curri.tel','curri.email',
                DB::raw('DATE_FORMAT(curri.f_nacimiento, "%d-%m-%Y") as f_nacimiento'),             
                'curri.permiso_trab',
                
                DB::raw('DATE_FORMAT(curri.f_vence_permiso_trab, "%d-%m-%Y") as f_vence_permiso_trab'),
                'curri.permiso_doc','curri.direccion','curri.cv_doc','curri.foto',
                'curri.id_nacionalidad', 'curri.id as id_curri',
                'curri.contacto_urgencia','curri.parentesco_urgencia','curri.tel_urgencia',
                DB::raw("CONCAT(UPPER(LEFT(nac.nacionalidad, 1)), LOWER(SUBSTRING(nac.nacionalidad, 2))) AS nacionalidad"),
                'prov.provincia','dist.distrito','corr.corregimiento',
                'cart.id as id_carta',
                'cart.salario',
                'cart.finicio',
                'cart.fterminacion',
                'cart.sel_tipo_contrato','cart.sel_tipo_salario',
                'cart.id_participante as id_part',
                'cart.aceptacion_ofl as doc_cofl',
                'cart.contworkfirmado as contrato_firmado',
                'cart.cod_cia','cart.cod_ceco',
                'cart.carta_presentacion',
                'cart.estado',
                'cart.num_colab',
                DB::raw("IF(part.marcacion = 1, 'SI', 'NO') AS marcacion"),
                'part.id_puesto','pos.descpue as puesto','est.nameund as unidad',
                'est.hrs_semanales','est.hrs_mensuales','est.horarios','cia.PAGADORA as cia','cia.NOM_CIA as ceco','df.proposito'
            ])
            ->first();
            $dependientes = collect();
            if ($data_parti) {
                $dependientes = DB::table('usr_part_dependientes as d')
                    ->where('d.id_curri', $data_parti->id_curri)
                    ->select([
                        'd.nombre',
                        'd.parentesco',
                        DB::raw('DATE_FORMAT(d.f_nacimiento, "%d-%m-%Y") as f_nacimiento')
                    ])
                    ->get();
            }
            $documentacion = DB::table('usr_part_curri_tipodocattach as ld')
                ->leftJoin('usr_part_curri_docattach as b', function($join) use ($data_parti) {
                    $join->on('ld.id', '=', 'b.iddoc')
                        ->where('b.id_curri', '=', $data_parti->id_curri);
                })
                ->select('ld.id as tipo', 'ld.nomdoc', 'b.downdoc', 'b.id as id_doc')
                ->get();

        if (!$data_parti) {
            return response()->json(['success' => false, 'message' => 'Carta no encontrada'], 404);
        }

        // Fechas cortas y largas
        $data_parti->finicio_corto = \Carbon\Carbon::parse($data_parti->finicio)->format('d-m-Y');
        $data_parti->finicio_largo = \Carbon\Carbon::parse($data_parti->finicio)->isoFormat('dddd D [de] MMMM [de] YYYY');
        $data_parti->fterminacion_corto = ($data_parti->fterminacion != '1900-01-01')
            ? \Carbon\Carbon::parse($data_parti->fterminacion)->format('d-m-Y') : '-';
        $data_parti->fterminacion_largo = ($data_parti->fterminacion != '1900-01-01')
            ? \Carbon\Carbon::parse($data_parti->fterminacion)->isoFormat('dddd D [de] MMMM [de] YYYY') : '-';

        // Tipo de documento
        if($data_parti->id_tipo_doc_letra == 'C') {
            $data_parti->tipo_doc = 'de la cédula de identidad personal No. '.$data_parti->num_doc;
            $data_parti->tipo_doc_firma = 'Cédula No. '.$data_parti->num_doc;
        } elseif ($data_parti->id_tipo_doc_letra == 'P') {
            $data_parti->tipo_doc = 'del pasaporte No. '.$data_parti->num_doc;
            $data_parti->tipo_doc_firma = 'Pasaporte No. '.$data_parti->num_doc;
        }

        // Saludo y género
        $data_parti->estimado = $data_parti->genero == 'F' ? 'Estimada' : 'Estimado';
        $data_parti->sr = $data_parti->genero == 'F' ? 'Señora' : 'Señor';
        $data_parti->masc_fem = $data_parti->genero == 'F' ? 'femenino' : 'masculino';

        // Tipo de contrato
        $data_parti->tipo_contrato = ($data_parti->sel_tipo_contrato == 'T') ? 'Definido' : 'Indefinido';
        $data_parti->estadocivil = ucfirst(strtolower($data_parti->estadocivil));
        // Tipo Salario
        $data_parti->sal = '$'.number_format($data_parti->salario, 2, '.', ',').' (por mes)';
        $data_parti->sal_hora = '$'.number_format(($data_parti->salario/$data_parti->hrs_mensuales), 4, '.', ',');
        $data_parti->tiposalario = 'BASE';
        // Tipo de documento
        if ($data_parti->sel_tipo_salario == 'H') {
            $data_parti->tiposalario = 'Por Hora';
        } elseif ($data_parti->sel_tipo_salario == 'B') {
            $data_parti->tiposalario = 'Base';
        }

        // Edad
        $data_parti->edad = \Carbon\Carbon::parse($data_parti->f_nacimiento)->age;

        // Nombre completo
        $data_parti->segnombre = $data_parti->segnombre ?? '';
        $data_parti->segapellido = $data_parti->segapellido ?? '';
        $data_parti->nombre_completo = trim($data_parti->prinombre.' '.$data_parti->segnombre.' '.$data_parti->priapellido.' '.$data_parti->segapellido);



        return response()->json([
            'success' => true,
            'data_parti' => $data_parti,
            'dependientes' => $dependientes,
            'documentacion' => $documentacion,
        ]);
    }


}
        
