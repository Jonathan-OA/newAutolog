<?php

namespace App\Http\Controllers\Modulos\Recebimento;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;

class ReceiptController extends Controller
{
    public function index(){
        return view('modulos.recebimento.grid'); 
    }

    public function items($id){
        return view('modulos.recebimento.gridDet')->with(['document' => $id]); 
    }

    public function getDocuments(){
        $documents = App\Document::all()->take(1000);
        return $documents->toArray();
    }

    public function getItems($document_id){
        $documents = App\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
