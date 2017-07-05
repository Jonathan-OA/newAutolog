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

    public function getDocuments(){
        $documents = App\Document::all()->take(1000);
        return $documents->toArray();
    }

    public function getItems($document_id){
        $documents = App\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
