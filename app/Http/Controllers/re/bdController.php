<?php

namespace App\Http\Controllers\re;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    
    use App\Models\go\Competencias;
    use App\Models\re\Curriculum;
    use Smalot\PdfParser\Parser;
    use Illuminate\Support\Carbon;
    use App\Models\Re\PruebaDisc;
    use App\Models\Re\PruebaVeritas;
    use App\Models\Re\PruebaApl;
    use App\Models\Re\PruebaResultadoApl;
    use App\Models\Re\PruebaRazi;
    use App\Models\re\usr_part_curri_conocimiento_adicional;
    use App\Models\re\usr_part_cursos_seminarios;
    use App\Models\re\usr_part_educacion;
    use App\Models\re\usr_part_experiencia_laboral;
    use App\Models\re\usr_part_familiares_empresa;
    use App\Models\re\usr_part_referencias_personales;
    use App\Models\re\Usr_parti_dependientes;
    use Illuminate\Support\Facades\Log;
    use thiagoalessio\TesseractOCR\TesseractOCR;
    use Illuminate\Http\JsonResponse;
    use Intervention\Image\ImageManager;
    use Intervention\Image\Facades\Image;
//use App\Models\go\Competencias;
 
class bdController extends Controller
{
    public function index()
    { $id_menu=28;
        $id_menu_sup=2;
        if (isset(Auth::user()->id)) 
        {   
            $data_tipo_documento= DB::select("SELECT id,letra,tipodoc FROM usr_tipo_documento");
            $data_tipo_permiso= DB::select("SELECT id,tipopermiso FROM usr_tipo_permiso_trab");
            $data_nacionalidades= DB::select("SELECT id,pais FROM usr_nacionalidad order by pais asc");
            $data_provincias= DB::select("SELECT id,provincia FROM dir_provincias order by provincia asc");
            $data_listdiscapacidad= DB::select("SELECT id,discapacidad FROM usr_listdiscapacidad");
            $data_areas_sub= DB::select("SELECT a.id as id_area, a.area, s.id as id_sub, s.subarea  FROM carreras_area  as a
            LEFT JOIN carreras_subarea s ON (a.id=s.id_area)
            order by a.area, s.subarea ");
            $data_nivel_educ= DB::select("SELECT id,nivel_educ FROM usr_nivel_educ");
            $data_estatus_educ= DB::select("SELECT id,estatuseduc FROM usr_estatus_educ");
            $data_rela_ref= DB::select("SELECT id,rela_ref FROM usr_tipo_rela_referencia");

            $fecha_actual = \Carbon\Carbon::now();
            $fecha_anterior = $fecha_actual->copy()->subYears(18)->format('Y-m-d');

            $data_listado = DB::select("SELECT 
                c.id, 
                c.prinombre, 
                c.priapellido, 
                c.email, 
                c.tel, 
                p.provincia AS prov_residencia,
                c.foto,
                e.ano, 
                e.entidad, 
                e.titulo, 
                n.nivel_educ, 
                s.estatuseduc,
                c.color_text,
                c.color_bg
            FROM usr_part_curriculum c
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
            order by c.prinombre, c.priapellido asc");
        
            $data_procesos = DB::select("SELECT 
                c.id_part_curriculum id_curri, 
                c.id_ofl, 
                p.descpue AS puesto,
                e.nameund AS unidad
            FROM usr_participantes c
            JOIN vacantes_solicitudes v ON v.id = c.id_ofl AND v.id_estatus < 4
            LEFT JOIN posiciones p ON p.id = v.id_puesto
            LEFT JOIN estructuras e ON e.id = v.id_ue
            LEFT JOIN usr_part_curriculum curri on (c.id_part_curriculum=curri.id and curri.estado_registro<>1)
            where c.id_etapa<7");

            $data_competencias = Competencias::select('id', 'nombre', 'orden', 'color')
            ->whereNotNull('orden')
            ->orderBy('orden', 'asc')
            ->get();

            return view('re.bd')
            ->with('id_menu',$id_menu)
            ->with('id_menu_sup',$id_menu_sup)
            ->with('data_tipo_documento',$data_tipo_documento)
            ->with('data_tipo_permiso',$data_tipo_permiso)
            ->with('data_nacionalidades',$data_nacionalidades)
            ->with('data_provincias',$data_provincias)
            ->with('data_listdiscapacidad',$data_listdiscapacidad)
            ->with('data_areas_sub',$data_areas_sub)
            ->with('data_nivel_educ',$data_nivel_educ)
            ->with('data_estatus_educ',$data_estatus_educ)
            ->with('data_rela_ref',$data_rela_ref)
            ->with('fecha_anterior',$fecha_anterior)
            ->with('data_listado',$data_listado)
            ->with('data_procesos',$data_procesos)                
            ->with('competencias',$data_competencias);            
        }
        else{   return view('auth.login');}
    }

    /*public function subirfoto(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request['image'];

            // Decodificar imagen base64
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $imageData = base64_decode($image_array_2[1]);

            // Crear nombre de archivo
            $filename = 'foto_temp_' . time() . '.png';
            $folder = 'temp/fotos/';
            $path = public_path($folder . $filename);

            // Crear carpeta si no existe
            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0777, true);
            }

            // Guardar la imagen
            file_put_contents($path, $imageData);

            // Retornar HTML + path en JSON 
            return response()->json([
               
                'html' => '<img src="' . asset($folder . $filename) . '" class="rounded" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #aeafb0;"id="img_photo" title="Cambiar foto">',
                'temp_path' => $folder . $filename
            ]);
        }
    }*/
/**
 * Sube una imagen en base64, la convierte a WebP y la guarda en /public/temp/fotos
 *
 * @param Request $request
 * @param ImageManager $imageManager
 * @return JsonResponse
 */

public function subirfoto(Request $request)
{
    if ($request->isMethod('POST')) {
        $data = $request->input('image');

        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $imageData = base64_decode($image_array_2[1]);

        $filename = 'foto_temp_' . time() . '.webp';
        $folder = 'temp/fotos/';
        $path = public_path($folder . $filename);

        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0777, true);
        }

        Image::make($imageData)
            ->encode('webp', 85)
            ->save($path);

        return response()->json([
            'html' => '<img src="' . asset($folder . $filename) . '" class="rounded" style="width:100px; height:100px; object-fit: cover; border: 2px solid #aeafb0;" id="img_photo" title="Cambiar foto">',
            'temp_path' => $folder . $filename
        ]);
    }

    return response()->json(['error' => 'Método no permitido'], 405);
}

    public function findreg(Request $request)
    {
        $id = $request['id'];
          $data_listado = DB::select("SELECT 
            c.id, 
            c.prinombre, 
            c.segnombre,
            c.priapellido, 
            c.segapellido,

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

            -- Foto lógica por género o personalizada
            c.foto,
            c.color_text,
            c.color_bg,

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

            WHERE c.id = $id");

            $data_estudios = DB::select("SELECT 
            CONCAT(UPPER(LEFT(n.nivel_educ , 1)), LOWER(SUBSTRING(n.nivel_educ , 2))) as nivel_educ,
            CONCAT(UPPER(LEFT(s.entidad , 1)), LOWER(SUBSTRING(s.entidad , 2))) as entidad,
            CONCAT(UPPER(LEFT(s.titulo , 1)), LOWER(SUBSTRING(s.titulo , 2))) as titulo,
            s.ano,             
            CONCAT(UPPER(LEFT(e.estatuseduc , 1)), LOWER(SUBSTRING(e.estatuseduc , 2))) as estatuseduc
            from usr_part_educacion s 
            LEFT JOIN usr_nivel_educ n ON n.id = s.nivel_educ
            LEFT JOIN usr_estatus_educ e ON  e.id = s.estatuseduc
            where s.id_curri = $id ORDER BY s.ano DESC");

             
            $data_cursos = DB::select("SELECT 
            CONCAT(UPPER(LEFT(c.entidad , 1)), LOWER(SUBSTRING(c.entidad , 2))) as entidad,
            CONCAT(UPPER(LEFT(c.nombre, 1)), LOWER(SUBSTRING(c.nombre , 2))) as nombre,
            c.ano                           
             from usr_part_cursos_seminarios c
             where c.id_curri = $id ORDER BY c.ano DESC");
             
            $data_otrosconocimientos = DB::select("SELECT 
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
            from usr_part_curri_conocimiento_adicional 
            where id_curri = $id");

            $data_referencia_personal = DB::select("SELECT 
            nombre,
            direccion,
            telefono
            from usr_part_referencias_personales
            where id_curri = $id");

            $data_experiencia_laboral = DB::select("SELECT 
            IF(r.empresa IS NULL, '-', r.empresa) as empresa, 
            IF(r.puesto IS NULL, '-', r.puesto) as puesto, 
            IF(r.subarea IS NULL, '-', r.subarea) as area, 
            IF(r.desde IS NULL, '-', DATE_FORMAT(r.desde, '%d-%m-%Y')) as desde, 
            IF(r.hasta IS NULL, '-', DATE_FORMAT(r.hasta, '%d-%m-%Y')) as hasta,             
            IF(r.motivo_salida IS NULL, '-', r.motivo_salida) as motivo_salida, 
            IF(r.telefono IS NULL, '-', r.telefono) as telefono, 
            IF(r.direccion IS NULL, '-', r.direccion) as direccion, 
            IF(r.salario IS NULL, '-', r.salario) as salario, 
            IF(r.jefe IS NULL, '-', r.jefe) as jefe
            from usr_part_experiencia_laboral r
            where r.id_curri = $id ORDER BY r.desde DESC");
            
            $data_familiares = DB::select("SELECT 
            CONCAT(UPPER(LEFT(nombre , 1)), LOWER(SUBSTRING(nombre , 2))) as nombre,
            CONCAT(UPPER(LEFT(parentesco , 1)), LOWER(SUBSTRING(parentesco , 2))) as parentesco,
            IF(unidad IS NULL, '-', unidad) as unidad
            from usr_part_familiares_empresa
            where id_curri = $id");
            
            $data_dependientes = DB::select("SELECT 
            d.nombre,
            CONCAT(UPPER(LEFT(d.parentesco , 1)), LOWER(SUBSTRING(d.parentesco , 2))) as parentesco,
            IF(d.f_nacimiento IS NULL, '-', DATE_FORMAT(d.f_nacimiento, '%d-%m-%Y')) as f_nacimiento
            from usr_part_dependientes d
            where d.id_curri = $id order by d.f_nacimiento asc");



            $prueba_apl = PruebaApl::with('resultados')->where('curriculum_id', $id)->orderBy('fecha_realizada', 'desc')->first();


           // return response()->json($data_listado);
            return response()->json([
                'datos_personales' => $data_listado,
                'educacion' => $data_estudios,
                'cursos' => $data_cursos,
                'otrosconocimientos' => $data_otrosconocimientos,
                'referencia_personal' => $data_referencia_personal,
                'experiencia_laboral' => $data_experiencia_laboral,
                'familiares' => $data_familiares,
                'dependientes' => $data_dependientes,
                'prueba_disc' => PruebaDisc::where('curriculum_id', $id)->orderBy('fecha_realizada', 'desc')->first(),       
                'prueba_razi' => PruebaRazi::where('curriculum_id', $id)->orderBy('fecha_realizada', 'desc')->first(),
                'prueba_apl' => $prueba_apl ? $prueba_apl : null,       
                'prueba_veritas' => PruebaVeritas::where('curriculum_id', $id)->orderBy('id', 'desc')->first(),

            ]);


    }

    public function destroy(Request $request)
    {
        $id = $request['id_curri'];
        $participantes = DB::table('usr_participantes')
            ->where('id_part_curriculum', $id)
            ->where('id_etapa', '<', 11)
            ->get();
        // Verificar si el curriculum tiene procesos activos
        // Si tiene procesos activos, no se puede eliminar
        // Retornar un mensaje de error
        if ($participantes->isNotEmpty()) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar el curriculum porque tiene procesos activos.'], 403);
        }
        $curriculum = Curriculum::find($id);
        
        if ($curriculum) {
            // Eliminar foto si existe
            if ($curriculum->foto && file_exists(public_path($curriculum->foto))) {
                unlink(public_path($curriculum->foto));
            }
            if ($curriculum->cv_doc && file_exists(public_path($curriculum->cv_doc))) {
                unlink(public_path($curriculum->cv_doc));
            }
                           
            $curriculum->conocimientosAdicionales()->delete();
            $curriculum->usrpartbitacora()->delete();
            $curriculum->usrpartcontactos()->delete();
            $curriculum->usrpartcurridocattach()->delete();
            $curriculum->usrpartcurrientrevistafun()->delete();
            $curriculum->usrpartcurrientrevistaini()->delete();
            $curriculum->usrpartcurriprupsico()->delete();
            $curriculum->usrpartcurrivalidacionref()->delete();
            $curriculum->usrpartcursosseminarios()->delete();
            $curriculum->usrpartdependientes()->delete();
            $curriculum->usrparteducacion()->delete();
            $curriculum->usrpartexperiencialaboral()->delete();
            $curriculum->usrpartfamiliaresempresa()->delete();
            $curriculum->usrparticipantes()->delete();
            $curriculum->usrpartreferenciaspersonales()->delete();
            $curriculum->usrpartobsterna()->delete();
            $curriculum->pruebasapl()->delete();
            $curriculum->pruebadisc()->delete();
            $curriculum->pruebasrazi()->delete();
            $curriculum->pruebasveritas()->delete();    

            $curriculum->delete();
            return response()->json(['success' => true,'message' => 'Hoja de vida eliminada correctamente']);
        } else {
            return response()->json(['success' => false,'message' => 'Hoja de vida no encontrada'], 404);
        }
    }

    public function savePruebas(Request $request)
    {
        $id_curri = $request->input('id_curri');

        /*if ($request->hasFile('archivo_razi')) {
            $archivo = $request->file('archivo_razi');
            if (!$archivo->isValid()) {
                dd($archivo->getErrorMessage(), $archivo->getError());
            }
        }else{echo "no llegaaaaaaaaaaaaa";}*/

        // Validar archivos (si existen)
        $request->validate([
            'archivo_disc' => 'nullable|file|max:10240', // 10 MB
            'archivo_apl' => 'nullable|file|max:10240',
            'archivo_razi' => 'nullable|file|max:10240',
        ]);
        // === DISC ===
            $archivo_disc = null;
            $id_disc = null;
            if ($request->filled('fecha_disc')) {
                if ($request->hasFile('archivo_disc') && $request->file('archivo_disc')->isValid()) {
                    $archivo = $request->file('archivo_disc');
                    $nombre = 'disc_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
                    $path = $archivo->storeAs('pruebas/disc', $nombre, 'public');
                    $archivo_disc = 'storage/' . $path;
                }

                $disc = PruebaDisc::create([
                    'curriculum_id' => $id_curri,
                    'fecha_realizada' => $request->input('fecha_disc'),
                    'informe' => $archivo_disc,
                    'observaciones' => $request->input('obs_disc'),
                    'puntaje_d' => $request->input('disc_d'),
                    'puntaje_i' => $request->input('disc_i'),
                    'puntaje_s' => $request->input('disc_s'),
                    'puntaje_c' => $request->input('disc_c'),
                ]);
                $id_disc = $disc->id;
            }

        // === APL ===
            $archivo_apl = null;
            $id_apl = null;

            if ($request->filled('fecha_apl')) {
                if ($request->hasFile('archivo_apl') && $request->file('archivo_apl')->isValid()) {
                    $archivo = $request->file('archivo_apl');
                    $nombre = 'apl_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
                    $path = $archivo->storeAs('pruebas/apl', $nombre, 'public');
                    $archivo_apl = 'storage/' . $path;
                }

                $apl = PruebaApl::create([
                    'curriculum_id' => $id_curri,
                    'fecha_realizada' => $request->input('fecha_apl'),
                    'informe' => $archivo_apl,
                    'observaciones' => $request->input('obs_apl'),
                ]);

                $id_apl = $apl->id;

                $competencias = json_decode($request->input('competencias_apl'), true);
                if (is_array($competencias)) {
                    foreach ($competencias as $comp) {
                        PruebaResultadoApl::create([
                            'prueba_id' => $apl->id,
                            'competencia_id' => $comp['competencia_id'],
                            'puntaje' => $comp['puntaje'],
                        ]);
                    }
                }
            }

        // === RAZI ===
            $archivo_razi = null;
            $id_razi = null;
            if ($request->filled('fecha_razi')) {
                if ($request->hasFile('archivo_razi') && $request->file('archivo_razi')->isValid()) {
                   $archivo = $request->file('archivo_razi');
                    $nombre = 'razi_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
                    $path = $archivo->storeAs('pruebas/razi', $nombre, 'public');
                    if (!$path) {
                        return response()->json(['message' => 'Fallo al guardar el archivo RAZI.'], 422);
                    }
                    $archivo_razi = 'storage/' . $path;
                }

                $razi = PruebaRazi::create([
                    'curriculum_id' => $id_curri,
                    'fecha_realizada' => $request->input('fecha_razi'),
                    'informe' => $archivo_razi,
                    'observaciones' => $request->input('obs_razi'),
                    'puntaje_v' => $request->input('razi_v'),
                    'puntaje_n' => $request->input('razi_n'),
                    'puntaje_a' => $request->input('razi_a'),
                    'general' => $request->input('razi_gen'),
                    'preg_acertadas' => $request->input('razi_acertadas'),
                ]);

                $id_razi = $razi->id;
            }
        // === VERITAS ===
            $id_veritas = null;
            if ($request->filled('fecha_veritas')) {
                $veritas = PruebaVeritas::create([
                    'curriculum_id' => $id_curri,
                    'fecha_realizada' => $request->input('fecha_veritas'),
                    'puntaje' => $request->input('veritas_result'),
                    'observaciones' => $request->input('obs_veritas'),
                ]);
                $id_veritas = $veritas->id;
            }
  
            
        return response()->json([
            'archivo_disc' => $archivo_disc,
            'id_disc' => $id_disc,
            'archivo_apl' => $archivo_apl,
            'id_apl' => $id_apl,
            'archivo_razi' => $archivo_razi,
            'id_razi' => $id_razi,            
            'id_veritas' => $id_veritas,
            'message' => 'Pruebas guardadas correctamente',
        ]);
    }
  
    public function eliminarPrueba(Request $request)
    {

        $id = $request['id'];
        $tipo = $request['tipo'];
        $data_competencias = null;
        
        if ($tipo == 'DISC') {
            // Eliminar archivo asociado si existe
            $prueba = PruebaDisc::find($id);
            if ($prueba && $prueba->informe) {
                $path = public_path($prueba->informe);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            // Eliminar registro de la base de datos
            PruebaDisc::where('id', $id)->delete();

        } elseif ($tipo == 'VERITAS') {
            PruebaVeritas::where('id', $id)->delete();
        } elseif ($tipo == 'APL') {
            // Eliminar archivo asociado si existe
            $prueba = PruebaApl::find($id);
            if ($prueba && $prueba->informe) {
                $path = public_path($prueba->informe);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            // Eliminar registros de la base de datos
            // Primero eliminamos los resultados asociados
            PruebaResultadoApl::where('prueba_id', $id)->delete();
            // Luego eliminamos la prueba
            PruebaApl::where('id', $id)->delete();
            
            $data_competencias = Competencias::select('id', 'nombre', 'orden')
            ->whereNotNull('orden')
            ->orderBy('orden', 'asc')
            ->get();

        } elseif ($tipo == 'RAZI') {
            // Eliminar archivo asociado si existe
            $prueba = PruebaRazi::find($id);
            if ($prueba && $prueba->informe) {
                $path = public_path($prueba->informe);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            // Eliminar registro de la base de datos
            PruebaRazi::where('id', $id)->delete();
        }

        return response()->json(['message' => 'Prueba eliminada correctamente',
        'competencias' => $data_competencias]);
    }

    public function importarResultados(Request $request)
    {
        // Validación correcta de los inputs
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240', // Max 10MB
            'tipo_file' => 'required|in:APL,RAZI,DISC',
        ]);


        if (!$request->hasFile('pdf_file') || !$request->file('pdf_file')->isValid()) {
        return response()->json([
            'message' => 'The pdf file failed to upload.',
            'errors' => ['pdf_file' => ['The pdf file failed to upload.']]
        ], 422);
        }
        // Log inputs recibidos para depuración
        Log::info('Inputs recibidos:', $request->only('tipo_file'));

        $file = $request->file('pdf_file');

        if ($request->input('tipo_file') == 'APL') {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();

            // Buscar fecha dd-mm-yyyy
            preg_match('/\b(\d{2}-\d{2}-\d{4})\b/', $text, $matchFecha);
            $fecha = $matchFecha[1] ?? null;
            Log::info("Fecha encontrada: " . ($fecha ?? 'No encontrada'));

            if (!$fecha) {
                return response()->json(['message' => 'Fecha no encontrada en el PDF'], 422);
            }

            // Buscar posición fecha en texto
            $posFecha = strpos($text, $fecha);
            if ($posFecha === false) {
                return response()->json(['message' => 'No se encontró la fecha en el texto'], 422);
            }

            $textoDesdeFecha = substr($text, $posFecha);

            // Buscar número 5 justo después de fecha (permitiendo espacios, tabs, saltos)
            preg_match('/' . preg_quote($fecha, '/') . '\s*5\s*/', $textoDesdeFecha, $matchFechaPagina);
            if (!$matchFechaPagina) {
                return response()->json(['message' => 'No se encontró el número 5 justo después de la fecha'], 422);
            }
            Log::info("Encontrado número de página 5 justo después de la fecha");

            // Extraer números que aparecen después del match
            $posMatch = strpos($textoDesdeFecha, $matchFechaPagina[0]);
            $textoDespues = substr($textoDesdeFecha, $posMatch + strlen($matchFechaPagina[0]));

            preg_match_all('/\b(\d{1,2})\b/', $textoDespues, $matchesValores);
            $valores = $matchesValores[1] ?? [];
            Log::info("Valores extraídos después de fecha y página: " . implode(", ", $valores));

            // Obtener competencias ordenadas
            $competencias = Competencias::select('id', 'nombre', 'orden')
                ->whereNotNull('orden')
                ->orderBy('orden', 'asc')
                ->get();

            $resultados = [];

            foreach ($competencias as $index => $competencia) {
                if (isset($valores[$index])) {
                    $valor = (int)$valores[$index];
                    if ($valor >= 1 && $valor <= 10) {
                        $resultados[$competencia->nombre] = [
                            'id' => $competencia->id,
                            'valor' => $valor,
                        ];
                        Log::info("Competencia '{$competencia->nombre}' valor asignado: {$valor}");
                    }
                } else {
                    Log::info("No hay valor para la competencia '{$competencia->nombre}'");
                }
            }

            return response()->json([
                'fecha' => $fecha,
                'competencias' => $competencias,
                'resultados' => $resultados,
            ]);
        }

        if ($request->input('tipo_file') == 'DISC') {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $pages = $pdf->getPages();

            if (!isset($pages[1])) {
                return response()->json(['message' => 'El PDF no tiene una segunda página'], 422);
            }

            $text = $pages[1]->getText();

            // Buscar los valores de D, I, S, C con regex
            preg_match_all('/\b([DISC])\s*=\s*([\d\.]+)%/', $text, $matches);

            $resultados = ['D' => null, 'I' => null, 'S' => null, 'C' => null];

            if (!empty($matches[1]) && !empty($matches[2])) {
                foreach ($matches[1] as $i => $letra) {
                    $resultados[$letra] = floatval($matches[2][$i]); // sin %
                }
            }
            return response()->json($resultados);
            
        }

        if ($request->input('tipo_file') == 'RAZI') {
            $pdfPath = $file->getPathname();
            $outputDir = storage_path('app/temp_razi');
            @mkdir($outputDir, 0755, true);

            $outputImage = $outputDir . '/razi_page';
            shell_exec("pdftoppm -f 1 -l 3 -png \"$pdfPath\" \"$outputImage\"");

            $resultados = [
                'fecha' => null,
                'verbal' => null,
                'numerica' => null,
                'abstracta' => null,
            ];

            foreach (glob($outputImage . '-*.png') as $imgPath) {
                $ocr = new TesseractOCR($imgPath);
                $ocr->lang('spa');
                $texto = $ocr->run();

                if (!$resultados['fecha']) {
                    preg_match('/\b(\d{2}[\/\-]\d{2}[\/\-]\d{4})\b/', $texto, $matchFecha);
                    if ($matchFecha) {
                        $resultados['fecha'] = $matchFecha[1];
                    }
                }

                preg_match('/Escala Verbal\s*[:\-]?\s*(\d{1,2})/i', $texto, $matchVerbal);
                preg_match('/Escala Num[eé]rica\s*[:\-]?\s*(\d{1,2})/i', $texto, $matchNumerica);
                preg_match('/Escala Abstracta\s*[:\-]?\s*(\d{1,2})/i', $texto, $matchAbstracta);

                if ($matchVerbal) $resultados['verbal'] = (int)$matchVerbal[1];
                if ($matchNumerica) $resultados['numerica'] = (int)$matchNumerica[1];
                if ($matchAbstracta) $resultados['abstracta'] = (int)$matchAbstracta[1];
            }

            return response()->json($resultados);
        }
    }

    // AGREGA CANDIDATOS
    public function store(Request $request)
    {
        $data = json_decode($request->input('datos'), true); // decodifica el JSON

        $prinombre= $data['prinombre'];
        $segnombre= $data['segnombre'];
        $priapellido= $data['priapellido'];
        $segapellido= $data['segapellido'];
        $genero= $data['genero'];
        $nacio_extran= $data['nacext'];
        $f_nacimiento= $data['f_nacimiento'];
        $id_tipo_doc_letra= $data['tipo_documento'];
        $num_docip= $data['num_docip'];
        $num_ss= $data['num_ss'];
        $estadocivil = $data['estado_civil'];
        $nacionalidad= $data['nacionalidad'];
        $f_vence_permiso_trab=null;
        $tipo_permiso=null;
        $ruta_permiso =null;
        if ($nacionalidad != 53) {   
            $tipo_permiso = $data['tipo_permiso'];
            $f_vence_permiso_trab = $data['f_vence_permiso'];    
            if ($request->hasFile('permiso_archivo')) {
                $archivo = $request->file('permiso_archivo');
                $extension = $archivo->getClientOriginalExtension();
                $nombreSeguro = 'permiso_' . date('Y-m-d_His') . '.' . $extension;
                $ruta_permiso = 'storage/'.$archivo->storeAs('permisos_tab', $nombreSeguro, 'public');
            } else {
                Log::warning('Archivo permiso no recibido aunque se esperaba.');
            }
        }

            
        if ($request->hasFile('archivoCV')) {
            $archivo = $request->file('archivoCV');
            $extension = $archivo->getClientOriginalExtension();
            $nombreSeguro = 'cv_' . date('Y-m-d_His') . '.' . $extension;
            $ruta_cv = 'storage/'.$archivo->storeAs('cv', $nombreSeguro, 'public');
        } 

        $sel_provincias= $data['provincia'];
        $sel_distrito= $data['distrito'];
        $sel_corregimiento= $data['corregimiento'];
        $dir= $data['direccion'];
        $telefono= $data['telefono'];
        $mail= $data['correo'];           
        $tipo_sangre= $data['tipo_sangre']; 
        $medico_cabecera= $data['medico_cabecera']; 
        $hospital= $data['hospital']; 
        $telhospital= $data['telhospital']; 
        $alergico= $data['alergico']; 
        $nombre_medicamento= $data['nombre_medicamento']; 
        $lesion= $data['lesion']; 
        $nombre_lesion= $data['nombre_lesion']; 
        $nombre_urgencia= $data['nombre_urgencia']; 
        $nombre_urgencia_parentesco= $data['nombre_urgencia_parentesco']; 
        $nombre_urgencia_telefono= $data['nombre_urgencia_telefono']; 
        $discapacidad= $data['discapacidad']; 
        $explique_disc= $data['explique_disc'];           
        $psicometrico= $data['autorizaciones']['chk_psico']; 
        $disponibilidadViaje= $data['autorizaciones']['chk_viajar']; 
        $verificacionDatos= $data['autorizaciones']['chk_verificar_info']; 
        $informacionCorrecta= $data['autorizaciones']['chk_afirmacion']; 
        $foto =null;
        if ($data['foto']!=null && $data['foto'] && file_exists(public_path($data['foto']))) {
            $tempPath = public_path($data['foto']);
            $finalName = 'foto_' . uniqid() . '.webp';
            $foto = 'storage/fotos/' . $finalName;
            rename($tempPath, public_path($foto));   
        }
        $colores_text = ['#0d6efd', // azul
            '#6610f2', // morado
            '#6f42c1', // púrpura
            '#d63384', // rosado
            '#dc3545', // rojo
            '#fd7e14', // naranja
            '#ffc107', // amarillo
            '#198754', // verde
            '#20c997', // verde menta
            '#0dcaf0', // cyan
            '#6c757d', // gris
            '#343a40', // negro suave
            '#4b0082', // índigo
            '#ff69b4', // rosado intenso
            '#40e0d0', // turquesa
            '#008080', // teal
            '#228b22', // verde bosque
            '#ff8c00', // naranja oscuro
            '#800000', // marrón
            '#ff4500'  // rojo anaranjado
        ];
        $colores_bg = ['#cfe2ff', // azul claro
            '#e0cffc', // morado claro
            '#e2d9f3', // lavanda
            '#f7d6e6', // rosa claro
            '#f8d7da', // rojo claro
            '#ffe5d0', // naranja claro
            '#fff3cd', // amarillo claro
            '#d1e7dd', // verde menta claro
            '#cff4fc', // cyan claro
            '#d4edda', // verde claro
            '#dee2e6', // gris claro
            '#ced4da', // gris medio
            '#e6e6fa', // lavanda claro
            '#fddde6', // rosa pastel
            '#e0ffff', // turquesa claro
            '#d0f0f0', // teal claro
            '#d0f5d0', // verde muy claro
            '#ffe4b5', // moccasin
            '#f5deb3', // trigo claro
            '#ffcccb'  // rosado suave
        ];
        $i = rand(0, count($colores_text) - 1);
        $color_tx = $colores_text[$i];
        $color_bg = $colores_bg[$i];
        try {
            $id_part_curriculum_alt= date("Y-m-d H:i:s.u");
            $new= new Curriculum();
            $new->id_part_curriculum_alt= $id_part_curriculum_alt;
            $new->prinombre= $prinombre;
            $new->segnombre= $segnombre;
            $new->priapellido= $priapellido;
            $new->segapellido= $segapellido;
            $new->genero= $genero;
            $new->nacio_extran= $nacio_extran;
            $new->f_nacimiento= $f_nacimiento;
            $new->id_nacionalidad= $nacionalidad;  
            $new->id_tipo_doc_letra= $id_tipo_doc_letra;     
            $new->num_doc= $num_docip;
            $new->num_ss= $num_ss;
            $new->estadocivil= $estadocivil;

            $new->tel= $telefono;
            $new->email= $mail;
            $new->id_provincia= $sel_provincias;
            $new->id_distrito= $sel_distrito;
            $new->id_corregimiento= $sel_corregimiento;
            $new->direccion= $dir;
            
            $new->permiso_trab = $tipo_permiso;
            $new->f_vence_permiso_trab	=$f_vence_permiso_trab;  
            $new->permiso_doc= $ruta_permiso;
            $new->tipo_sangre= $tipo_sangre;
            $new->medico= $medico_cabecera;
            $new->hospital= $hospital;
            $new->tel_medico= $telhospital;
            $new->sufre_alergia_medicamento= $alergico;
            $new->medicamento= $nombre_medicamento;
            $new->sufre_lesion_laboral= $lesion;
            $new->lesion_laboral= $nombre_lesion;
            $new->contacto_urgencia= $nombre_urgencia;
            $new->parentesco_urgencia= $nombre_urgencia_parentesco;
            $new->tel_urgencia= $nombre_urgencia_telefono;
            $new->discapacidad= $discapacidad;
            $new->detalle_descapacidad= $explique_disc;
            $new->cv_doc= $ruta_cv;     
            $new->examen_psicometrico= $psicometrico;
            $new->disponibilidad_viajar= $disponibilidadViaje;
            $new->verificar_informacion= $verificacionDatos;
            $new->informacion_verdadera= $informacionCorrecta;
            $new->foto = $foto;
            $new->color_text = $color_tx;
            $new->color_bg = $color_bg;                
            $new->save();
                
            foreach ($data['referencias'] as $ref) {
                usr_part_referencias_personales::create([
                    'id_curri' => $new->id,
                    'nombre' => $ref['nombre'],
                    'direccion' => $ref['direccion'],
                    'telefono' => $ref['telefono']
                ]);
            }
                 
            usr_part_curri_conocimiento_adicional::create([
                'id_curri' => $new->id,
                'espanol' => $data['conocimientos_adicionales']['espanol'],
                'ingles' => $data['conocimientos_adicionales']['ingles'],
                'computadora' => $data['conocimientos_adicionales']['dominioComputadora'],
                'word' => $data['conocimientos_adicionales']['manejoWord'],
                'excel' => $data['conocimientos_adicionales']['manejoExcel'],
                'powerpoint' => $data['conocimientos_adicionales']['manejoPPT'],
                'otros' => $data['conocimientos_adicionales']['otroConocimiento'],
                'sedan' => $data['conocimientos_adicionales']['sedan'],
                'camion' => $data['conocimientos_adicionales']['camion'],
                'trailer' => $data['conocimientos_adicionales']['trailer'],
                'moto' => $data['conocimientos_adicionales']['moto'],
                'montacarga' => $data['conocimientos_adicionales']['montacargas']
            ]);
                $idarea=null;
                $area=null;               
     
                foreach ($data['experiencias']as $exp) {
                    if (isset($exp['subarea']) && strlen($exp['subarea']) > 4) {
                        $cad = explode('-', $exp['subarea'], 2);
                        $idarea = $cad[0];
                        $area = $cad[1];                        
                    }
                    usr_part_experiencia_laboral::create([
                        'id_curri' => $new->id,
                        'empresa' => $exp['empresa'],
                        'puesto' => $exp['puesto'],
                        'id_subarea' => $idarea,
                        'subarea' => $area,
                        'desde' => $exp['desde'],
                        'hasta' => $exp['hasta'],
                        'motivo_salida' => $exp['motivo_salida'],
                        'telefono' => $exp['telefono'],
                        'direccion' => $exp['direccion'],
                        'salario' => $exp['salario'],
                        'jefe' => $exp['jefe'],
                    ]);
                }

                foreach ($data['educaciones']as $est) {
                    usr_part_educacion::create([
                        'id_curri' => $new->id,
                        'nivel_educ' => $est['nivel'],
                        'entidad' => $est['institucion'],
                        'titulo' => $est['carrera'],
                        'ano' => $est['ano'],
                        'estatuseduc' => $est['estatus']
                    ]);
                }

                foreach ($data['cursos']as $cur) {
                    usr_part_cursos_seminarios::create([
                        'id_curri' => $new->id,
                        'entidad' => $cur['institucion'],
                        'nombre' => $cur['nombre'],
                        'ano' => $cur['ano']
                    ]);
                }
                
                foreach ($data['familiares']as $fam) {
                    usr_part_familiares_empresa::create([
                        'id_curri' => $new->id,
                        'nombre' => $fam['nombre'],
                        'parentesco' => $fam['parentesco'],
                        'unidad' => $fam['unidad']
                    ]);
                }
            foreach ($data['dependientes']as $dep) {
                Usr_parti_dependientes::create([
                    'id_curri' => $new->id,
                    'nombre' => $dep['nombre'],
                    'parentesco' => $dep['parentesco'],
                    'f_nacimiento' => $dep['fechaNacimiento']
                ]);
            }

            $data_listado = DB::select("SELECT 
                c.id, 
                c.prinombre, 
                c.priapellido, 
                c.email, 
                c.tel, 
                p.provincia AS prov_residencia,
                c.foto,
                e.ano, 
                e.entidad, 
                e.titulo, 
                n.nivel_educ, 
                s.estatuseduc,
                c.color_text,
                c.color_bg
            FROM usr_part_curriculum c
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
            where c.id= $new->id
            order by c.prinombre, c.priapellido asc"
            );

        return response()->json(['success' => true, 'message' => 'Guardado con éxito', 'data_listado' => $data_listado], 200);
        } catch (\Exception $e) {
            // Registrar el error en el log
            Log::error('Error en store(): ' . $e->getMessage());    
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al guardar', 'error' => $e->getMessage()], 500);
        }
    }
}