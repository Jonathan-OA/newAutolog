<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Auth;

class ProductionController extends Controller
{
    public function index(){
        return view('modules.production.grid'); 
    }

    /**
     * Mostra o formulário para criação de documento de produção.
     *
     * @return Response
     */
    public function create()
    {

        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('documents_prod_add',Auth::user()->user_type_code)){
            //Busca os tipos de documentos para o movimento especificado
            $document_types = App\Models\DocumentType::getDocumentTypes('030');

            return view('modules.production.createDocument')->with('document_types',$document_types);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(url('production'));
        }
    }

    public function items($id){
        return view('modules.production.gridDet')->with(['document' => $id]); 
    }

    public function getItems($document_id){
        $documents = App\Models\DocumentItem::where('document_id',$document_id)->get();
        return $documents->toArray();
    }
}
