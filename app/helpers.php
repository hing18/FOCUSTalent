
<?php
use Illuminate\Support\Facades\DB;
if (! function_exists('current_user')) {
    function current_user()
    {
        return (auth()->user());
    }
}

if (! function_exists('photo_user')) {
    function photo_user($id)
    {        
        $query = DB::select("SELECT emp.photo as photo, emp.genero FROM users as us left join m_empleados as emp on (us.codigo=emp.id) where us.id=$id");           
        foreach($query as $s){
            if($s->photo!=null)
            {   echo '<img src="data:image/png;base64,'.base64_encode($s->photo).'" alt="Profile" class="rounded-circle"/>';}
            else
            {
                if($s->genero=='F'){ echo'<img src="/FOCUSTalent/public/storage/profiles/photo/ella.png" alt="Profile" class="rounded-circle">';}
                else { echo'<img src="/FOCUSTalent/public/storage/profiles/photo/el.png" alt="Profile" class="rounded-circle">';}}
        }
    }
}

if (! function_exists('select_tree_cat_id')) {
    function select_tree_cat_id($id,$level){
        $subs = get_cats_by_cat_id($id);
        
        if(count($subs)>0){
            foreach($subs as $s){
                $nameund=$s->nameund;
                echo "<option value=\"$s->id\" > ".str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level)."$nameund </option>";
                select_tree_cat_id($s->id,$level+1);
            }
        }
    }
}


if (! function_exists('get_cats_by_cat_id')) {
    function get_cats_by_cat_id($id){
        $data= array();
        $query = DB::select("Select * from estructuras where id_sup = $id order by nameund");
        foreach ($query as $r)
        {
            $data[]=$r;
        }
        return $data;
    }
}



if (! function_exists('menu_id')) {
    function menu_id($id_menu,$id_menu_sup,$id_user){
        $data= array();
        $query = DB::select("Select m.id, m.name_menu, m.id_sup, m.link, m.icono, m.orden, m.tipo 
        from 
        usr_rol ur 
        inner join rol_menu rm on (rm.id_rol=ur.id_rol) 
        inner join menu m on (rm.id_menu=m.id and m.tipo in ('S','P','M') )
        where 
        ur.id_usr=$id_user 
        order by m.orden");
        foreach ($query as $r)
        {$activo="";
            if($r->id!=null){ 
                if($r->tipo=='S'){ $activo="collapsed";
                    if($id_menu==$r->id) {   $activo="collapse";}  
                    echo '<li class="nav-item"><a class="nav-link '.$activo.'" href="'.route($r->link).'">'.$r->icono.'<span>'.$r->name_menu.'</span></a></li>';}
                if($r->tipo=='M'){  echo '<li class="nav-heading">'.$r->name_menu.'</li>';}
                if($r->tipo=='P'){ $activo1="collapsed";$activo2="collapse"; 
                    if($id_menu_sup==$r->id){   $activo1=" collapse";   $activo2=" collapsed show";}  
                    echo '<li class="nav-item">
                    <a class="nav-link '.$activo1.'" data-bs-target="#'.$r->id.'-nav" data-bs-toggle="collapse" href="#">
                        '.$r->icono.'<span>'.$r->name_menu.'</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="'.$r->id.'-nav" class="nav-content '.$activo2.'" data-bs-parent="#sidebar-nav">';
                    sub_menu_id($r->id,$id_user,$id_menu);
                    echo '
                        </ul>
                    </li>';
                }
            }
        }
    }
}


if (! function_exists('sub_menu_id')) {
    function sub_menu_id($id,$id_user,$id_menu){
        $data= array();
        $query2 = DB::select("Select m.id, m.name_menu, m.id_sup, m.link, m.icono, m.orden, m.tipo 
        from 
        usr_rol ur 
        inner join rol_menu rm on (rm.id_rol=ur.id_rol) 
        inner join menu m on (rm.id_menu=m.id and m.id_sup=$id)
        where 
        ur.id_usr=$id_user 
        order by m.orden asc");
        foreach ($query2 as $r2)
        {
            if($r2->id!=null){ if($r2->tipo=='H'){ $activo=""; if($id_menu==$r2->id){$activo=" class='active'";}  echo '<li>
            <a href="'.route("$r2->link").'" '.$activo.'>
            '.$r2->icono.'<span>'.$r2->name_menu.'</span>
            </a>
        </li>';}}
        }
       
    }
}