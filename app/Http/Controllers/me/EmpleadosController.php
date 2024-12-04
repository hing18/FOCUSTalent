<?php

namespace App\Http\Controllers\me;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                    'est1.nameund as uni')
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
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_employee=$data['cod'];
             $query_employee= DB::select("SELECT emp.id as id_employee, emp.prinombre, emp.segnombre, emp.priapellido, emp.segapellido, emp.photo, emp.genero, emp.nacio_extran, emp.f_nacimiento, 
            emp.id_nacionalidad, emp.id_tipo_doc_letra, emp.num_doc, emp.num_ss, emp.estadocivil, emp.f_vencimiento, emp.tel, 
            emp.email, emp.id_provincia, emp.id_distrito, emp.id_corregimiento, emp.direccion, emp.discapacidad, emp.detalle_descapacidad, emp.cv_doc, emp.permiso_trab, emp.f_vence_permiso_trab, emp.permiso_doc, emp.id_posicion, 
            emp.id_estatus, emp.salario, emp.finicio, emp.fterminacion, emp.tipo_contrato, emp.tipo_salario, emp.coef_intelectual, 
            emp.niv_academico,
            pos.descpue,
            est1.nameund
            FROM m_empleados emp 
            LEFT JOIN posiciones pos on (emp.id_posicion=pos.id)
            LEFT JOIN estructuras est1 on (est1.id=pos.iduni)
            where emp.id=$id_employee");

            foreach ($query_employee as $r)
            {   if($r->photo!=null)
                {   $photo= '<img src="data:image/png;base64,'.base64_encode($r->photo).'" alt="Profile" width="100" class="rounded-circle" id="img_photo" title="Cambiar foto"/>';}
                else
                { if($r->genero=='F'){ $photo='<img src="/FOCUSTalent/public/storage/profiles/photo/ella.png" alt="Profile"  height="100" class="rounded-circle" id="img_photo" title="Cambiar foto"/>';}
                else { $photo='<img src="/FOCUSTalent/public/storage/profiles/photo/el.png" alt="Profile" width="100" class="rounded-circle" id="img_photo" title="Cambiar foto"/>';}}
                $id_employee = $r->id_employee;
                $prinombre = $r->prinombre;
                $segnombre = $r->segnombre; 
                $priapellido = $r->priapellido; 
                $segapellido = $r->segapellido; 
                #$photo = $r->photo; 
                $genero = $r->genero; 
                $nacio_extran = $r->nacio_extran; 
                $f_nacimiento = $r->f_nacimiento; 
                $id_nacionalidad = $r->id_nacionalidad; 
                $id_tipo_doc_letra = $r->id_tipo_doc_letra; 
                $num_doc = $r->num_doc; 
                $num_ss = $r->num_ss; 
                $estadocivil = $r->estadocivil; 
                $f_vencimiento = $r->f_vencimiento; 
                $tel = $r->tel; 
                $email = $r->email; 
                $id_provincia = $r->id_provincia; 
                $id_distrito = $r->id_distrito; 
                $id_corregimiento = $r->id_corregimiento; 
                $direccion = $r->direccion; 
                $discapacidad = $r->discapacidad; 
                $detalle_descapacidad = $r->detalle_descapacidad; 
                $cv_doc = $r->cv_doc; 
                $permiso_trab = $r->permiso_trab; 
                $f_vence_permiso_trab = $r->f_vence_permiso_trab; 
                $permiso_doc = $r->permiso_doc; 
                $id_posicion = $r->id_posicion; 
                $id_estatus = $r->id_estatus; 
                $salario = $r->salario; 
                $finicio = $r->finicio; 
                $fterminacion = $r->fterminacion; 
                $tipo_contrato = $r->tipo_contrato; 
                $tipo_salario = $r->tipo_salario; 
                $coef_intelectual = $r->coef_intelectual; 
                $niv_academico = $r->niv_academico;
                $descpue = $r->descpue;
                $nameund = $r->nameund;
            }
        $salidaJson=array(
            "id_employee" => $id_employee,
            "prinombre"=> $prinombre,
            "segnombre"=> $segnombre, 
            "priapellido"=> $priapellido,
            "segapellido"=> $segapellido,
            "photo"=> $photo,
            "genero"=> $genero,
            "nacio_extran"=> $nacio_extran,
            "f_nacimiento"=> $f_nacimiento,
            "id_nacionalidad"=> $id_nacionalidad,
            "id_tipo_doc_letra"=> $id_tipo_doc_letra,
            "num_doc"=> $num_doc,
            "num_ss"=> $num_ss,
            "estadocivil"=> $estadocivil,
            "f_vencimiento"=> $f_vencimiento,
            "tel"=> $tel,
            "email"=> $email,
            "id_provincia"=> $id_provincia,
            "id_distrito"=> $id_distrito,
            "id_corregimiento"=> $id_corregimiento,
            "direccion"=> $direccion,
            "discapacidad"=> $discapacidad,
            "detalle_descapacidad"=> $detalle_descapacidad,
            "cv_doc"=> $cv_doc,
            "permiso_trab"=> $permiso_trab,
            "f_vence_permiso_trab"=> $f_vence_permiso_trab,
            "permiso_doc"=> $permiso_doc,
            "id_posicion"=> $id_posicion,
            "id_estatus"=> $id_estatus,
            "salario"=> $salario,
            "finicio"=> $finicio,
            "fterminacion"=> $fterminacion,
            "tipo_contrato"=> $tipo_contrato,
            "tipo_salario"=> $tipo_salario,
            "coef_intelectual"=> $coef_intelectual,
            "niv_academico"=> $niv_academico,
            "descpue"=> $descpue,
            "nameund"=> $nameund,             
        );

echo(json_encode($salidaJson));
            
        }
        else{   return view('auth.login');}
    }

    
    public function subirfoto(Request $request)
    {    if (isset(Auth::user()->id)) 
        {
            if($request->isMethod('POST'))
            {

                    $data = $request['image'];
                    $id_employee=$request['cod'];
                    $image_array_1 = explode(";", $data);
                    $image_array_2 = explode(",", $image_array_1[1]);
                    $data = base64_decode($image_array_2[1]);
                    $imageName = time() . '.png';
                    file_put_contents($imageName, $data);
                    $image_file = addslashes(file_get_contents($imageName));
                    DB::table('m_empleados')->where('id','=', $id_employee)->update(['photo' => $data]);
                    $dataresp='-';
                    $query = DB::select("SELECT photo FROM m_empleados WHERE id= $id_employee");
                    foreach ($query as $res)
                    {   $dataresp= $res->photo;
                    unlink($imageName);}
                    
                    echo('<img src="data:image/png;base64,'.base64_encode($dataresp).'" alt="Profile" width="100" class="rounded-circle" id="img_photo" title="Cambiar foto" />');

            }
        }        
        else{   return view('auth.login');}
    }
}
