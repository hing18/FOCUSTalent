<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\Entrevistas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EntrevistasContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $id_menu=16;
        $id_menu_sup=2;
        if (isset(Auth::user()->id)) 
        {
            return view('re.entrevistas')
            ->with('id_menu',$id_menu)
            ->with('id_menu_sup',$id_menu_sup);
        }
        else{   return view('auth.login');}
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
    public function show(Entrevistas $entrevistas)
    {
        //
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
