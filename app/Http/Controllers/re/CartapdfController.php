<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\Ofertas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartapdfController extends Controller
{
    public function index()
    {   
        if (isset(Auth::user()->id)) 
        {
            $data= request()->except('_token');
         
        //$descpue= $data['descpue']; 

               $pdf = Pdf::loadView('re.PDFcartaoferta',$data); 
           return $pdf->stream();
         //   echo($salida);
         //   return $pdf->download('file.pdf');
        }
        else{   return view('auth.login');}
    }
}
