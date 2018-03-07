<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App;

use App\Http\Requests;

class ImportacaoGeralController extends Controller
{
    public function index(){
        $documents = DB::connection('dbantigo')->table('doccab')->where('doctip_codigo','OP')->get();
        $count = count($documents);
        foreach($documents as $document){
            //INSERE DOCCAB
            $newDoc = new App\Document();
            $newDoc->company_id = 1;
            $newDoc->number = $document->DOCCAB_NUMERO;
            $newDoc->customer_id = $document->CLIFOR_CODIGO;
            $newDoc->emission_date = date('Y-m-d H:i:s');
            $newDoc->document_type_code = $document->DOCTIP_CODIGO;
            $newDoc->document_status_id = $document->DOCCAB_STATUS;
            $newDoc->save();

            //Insere DOCITM
             $itens = DB::connection('dbantigo')->table('docitm')->where('doccab_seq',$document->DOCCAB_SEQ)->get();
             foreach($itens as $item){
                $newItem = new App\DocumentItem();
                $newItem->company_id = 1;
                $newItem->document_id = $newDoc->id;
                $newItem->product_code = $item->PRDCAD_CODIGO;
                $newItem->qty = $item->DOCITM_QDE;
                $newItem->uom_code = $item->UOMCAD_CODIGO;
                $newItem->status = $item->DOCITM_STATUS;
                $newItem->save();
             }
        }

        echo $count.' Documentos Importados';
    }
}
