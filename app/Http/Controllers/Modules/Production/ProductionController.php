<?php

namespace App\Http\Controllers\Modules\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;

class ProductionController extends Controller
{
    public function index(){
        return view('modules.production.grid'); 
    }

    public function items($id){
        return view('modules.production.gridDet')->with(['document' => $id]); 
    }

    //Função que retorna os documentos de produção
    public function getDocuments($qty = '10000'){
        $documents = App\Models\Document::all()->take($qty);
        return $documents->toArray();
    }

    public function getItems($document_id){
        $documents = App\Models\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
