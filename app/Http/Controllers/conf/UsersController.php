<?php

namespace App\Http\Controllers\conf;

use App\Http\Controllers\Controller;
use App\Models\conf\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $id_menu=13;
        $id_menu_sup=12;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user ");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            {   return view('conf.users')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup);
            }else{
                return redirect()->route('login');
            }
        }else{
            return redirect()->route('login');
        }
    }

 
   public function reset_pass(Users $users)
   {
        $data= request()->except('_token');
        DB::table('users')
        ->where('id','=', Auth::user()->id)
        ->update(['password' => Hash::make($data['pass1']),'reset_pass'=>0]);

        $id_user=Auth::user()->id;
        $pag='dashboard';

        $query = DB::select("SELECT link 
            FROM menu 
            WHERE id IN (
                SELECT id_menu 
                FROM rol_menu 
                WHERE id_rol = (
                    SELECT id_rol  from usr_rol
                    WHERE id_usr = $id_user
                )
            ) 
            AND tipo IN ('S', 'H') 
            ORDER BY id ASC 
            LIMIT 1;");
            foreach ($query as $r)
            {   $pag=$r->link; }
        
            return redirect()->route($pag);  
        #return redirect()->route($data['pag']);
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
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        //
    }

}
