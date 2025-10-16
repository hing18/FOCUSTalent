<?php

namespace App\Http\Controllers\me;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    public function index()
    {
        $id_menu=22;
        $id_menu_sup=21;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            {               
                $query_empleados = DB::table('m_empleados as emp')
                ->select('emp.id', 
                    'emp.prinombre', 
                    'emp.priapellido', 
                    'pos.descpue', 
                    'est.nameund as ue', 
                    'est1.nameund as uni',
                    'emp.foto')
                ->leftjoin('posiciones as pos','pos.id','=','emp.id_posicion') 
                ->leftjoin('estructuras as est','est.id','=','pos.idue')
                ->leftjoin('estructuras as est1','est1.id','=','pos.iduni')    

    //            ->orderBy('emp.prinombre')->orderBy('emp.priapellido')  ->orderBy('est.nameund') ->orderBy('est1.nameund')       
                ->get();
                
                $data_nacionalidades= DB::select("SELECT id,pais FROM usr_nacionalidad order by pais asc");
                $data_tipo_documento= DB::select("SELECT id,letra,tipodoc FROM usr_tipo_documento");
                $data_tipo_permiso= DB::select("SELECT id,tipopermiso FROM usr_tipo_permiso_trab");

                return view('me.empleados')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('empleados',$query_empleados)        
                ->with('data_nacionalidades',$data_nacionalidades)
                ->with('data_tipo_documento',$data_tipo_documento)
                ->with('data_tipo_permiso',$data_tipo_permiso);
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }

    public function employee(Request $request)
{
    if (!Auth::check()) {
        return view('auth.login');
    }

    $id_employee = $request->input('cod');

    $query_employee = DB::selectOne("
        SELECT 
            emp.id as id_employee, emp.prinombre, emp.segnombre, emp.priapellido, emp.segapellido, emp.foto, 
            emp.color_text, emp.color_bg, emp.genero, emp.nacio_extran, emp.f_nacimiento, emp.id_nacionalidad, 
            emp.id_tipo_doc_letra, emp.num_doc, emp.num_ss, emp.estadocivil, emp.f_vencimiento, emp.tel, emp.email, 
            emp.id_provincia, emp.id_distrito, emp.id_corregimiento, emp.direccion, emp.discapacidad, 
            emp.detalle_descapacidad, emp.cv_doc, emp.permiso_trab, emp.f_vence_permiso_trab, emp.permiso_doc, 
            emp.id_posicion, emp.id_estatus, emp.salario, emp.finicio, emp.fterminacion, emp.tipo_contrato, 
            emp.tipo_salario, emp.coef_intelectual, emp.niv_academico,
            pos.descpue, est1.nameund
        FROM m_empleados emp 
        LEFT JOIN posiciones pos ON emp.id_posicion = pos.id
        LEFT JOIN estructuras est1 ON est1.id = pos.iduni
        WHERE emp.id = ?
    ", [$id_employee]);

    if (!$query_employee) {
        return response()->json(['error' => 'Empleado no encontrado'], 404);
    }

    // Convertimos el resultado en array directamente
    $salidaJson = [
        "id_employee" => $query_employee->id_employee,
        "prinombre" => $query_employee->prinombre,
        "segnombre" => $query_employee->segnombre,
        "priapellido" => $query_employee->priapellido,
        "segapellido" => $query_employee->segapellido,
        "foto" => $query_employee->foto,
        "color_text" => $query_employee->color_text,
        "color_bg" => $query_employee->color_bg,
        "genero" => $query_employee->genero,
        "nacio_extran" => $query_employee->nacio_extran,
        "f_nacimiento" => $query_employee->f_nacimiento,
        "id_nacionalidad" => $query_employee->id_nacionalidad,
        "id_tipo_doc_letra" => $query_employee->id_tipo_doc_letra,
        "num_doc" => $query_employee->num_doc,
        "num_ss" => $query_employee->num_ss,
        "estadocivil" => $query_employee->estadocivil,
        "f_vencimiento" => $query_employee->f_vencimiento,
        "tel" => $query_employee->tel,
        "email" => $query_employee->email,
        "id_provincia" => $query_employee->id_provincia,
        "id_distrito" => $query_employee->id_distrito,
        "id_corregimiento" => $query_employee->id_corregimiento,
        "direccion" => $query_employee->direccion,
        "discapacidad" => $query_employee->discapacidad,
        "detalle_descapacidad" => $query_employee->detalle_descapacidad,
        "cv_doc" => $query_employee->cv_doc,
        "permiso_trab" => $query_employee->permiso_trab,
        "f_vence_permiso_trab" => $query_employee->f_vence_permiso_trab,
        "permiso_doc" => $query_employee->permiso_doc,
        "id_posicion" => $query_employee->id_posicion,
        "id_estatus" => $query_employee->id_estatus,
        "salario" => $query_employee->salario,
        "finicio" => $query_employee->finicio,
        "fterminacion" => $query_employee->fterminacion,
        "tipo_contrato" => $query_employee->tipo_contrato,
        "tipo_salario" => $query_employee->tipo_salario,
        "coef_intelectual" => $query_employee->coef_intelectual,
        "niv_academico" => $query_employee->niv_academico,
        "descpue" => $query_employee->descpue,
        "nameund" => $query_employee->nameund,
    ];

    return response()->json($salidaJson);
}


    

public function subirfoto(Request $request)
{
    if (!Auth::check()) {
        return view('auth.login');
    }

    if ($request->isMethod('POST')) {
        // Validar entrada mínima
        $data = $request->input('image');
        $id_employee = $request->input('cod');

        if (!$data || !$id_employee) {
            return response()->json(['error' => 'Datos incompletos'], 400);
        }

        // Procesar la imagen base64
        [$typeInfo, $base64Data] = explode(',', $data);
        $imageData = base64_decode($base64Data);

        // Generar nombre único
        $imageName = 'fotoPerfil_' . time() . '.png';
        $storagePath = "public/profiles/photo/{$imageName}";

        // Guardar la imagen en storage/app/public/profiles/photo
        Storage::put($storagePath, $imageData);

        // Ruta accesible desde el navegador gracias a storage:link
        $relativeUrl = "storage/profiles/photo/{$imageName}";

        // Actualizar base de datos
        DB::table('m_empleados')
            ->where('id', '=', $id_employee)
            ->update(['foto' => $relativeUrl]);

        // Devolver HTML de la imagen
        return '<img src="' . asset($relativeUrl) . '" class="rounded-circle" style="background:#FFFFFF; width: 100px; height: 100px; object-fit: cover; border: 1px solid #aeafb0;">';
    }

    return response()->json(['error' => 'Método no permitido'], 405);
}
}
