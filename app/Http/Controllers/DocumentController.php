<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
use Flash;

class DocumentController extends Controller
{
    /**
     * Realiza a liberação do documento
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function liberateDoc($document_id)
    {
        //Valida se usuário possui permissão para liberar documento
        if(App\Models\User::getPermission('documents_lib',Auth::user()->user_type_code)){
            $libDoc = App\Models\Document::liberate($document_id); 
            if($libDoc['erro'] <> 0){
                //Erro na liberação
                Flash::error($libDoc['msg']);
            }else{
                 //Sucesso na liberação
                 Flash::success($libDoc['msg']);
            }
            return redirect(url($libDoc['urlRet']));

        }else{
             //Sem permissão
             Flash::error(Lang::get('validation.permission'));
             return redirect(route('production'));
        }
        
    }

    /**
     * Realiza o estorno de um documento
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function returnDoc($document_id)
    {
        //Valida se usuário possui permissão para retornar documento
        if(App\Models\User::getPermission('documents_ret',Auth::user()->user_type_code)){
            $retDoc = App\Models\Document::return($document_id); 
            if($retDoc['erro'] <> 0){
                //Erro no retorno
                Flash::error($retDoc['msg']);
            }else{
                //Sucesso no retorno
                Flash::success($retDoc['msg']);
            }
            return redirect(url($retDoc['urlRet']));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('production'));
        }


    }

}
