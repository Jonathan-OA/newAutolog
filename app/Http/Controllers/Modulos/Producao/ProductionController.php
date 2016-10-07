<?php

namespace App\Http\Controllers\Modulos\Producao;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;

class ProductionController extends Controller
{
    public function index(){
        $documents = App\Document::all();
        return view('modulos.producao.grid')->with(['documents' => json_encode($documents)]); 
    }

    public function getDocuments(){
        $documents = App\Document::all()->take(1000);
        return $documents->toArray();
    }
}
