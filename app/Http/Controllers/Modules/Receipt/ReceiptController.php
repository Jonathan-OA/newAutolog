<?php

namespace App\Http\Controllers\Modules\Receipt;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;

class ReceiptController extends Controller
{
    public function index(){
        return view('modules.receipt.grid'); 
    }

    public function items($id){
        return view('modules.receipt.gridDet')->with(['document' => $id]); 
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
