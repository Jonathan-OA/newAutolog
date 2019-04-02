<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
use Flash;
use Lang;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentItemRepository;

class DocumentController extends Controller
{

    private $documentRepository;
    private $documentItemRepository;

    public function __construct(DocumentRepository $docRepo, DocumentItemRepository $itemRepo)
    {
        $this->documentRepository = $docRepo;
        $this->documentItemRepository = $itemRepo;
    }

    /**
     * Realiza a liberação do documentos
     *
     * @param  int  $id
     * @param varchar $module
     * @return \Illuminate\Http\Response
     */
    public function liberate($module, Request $request)
    {
        $input = $request->all(); 
        //Valida se é uma ONDA ou não pela quantidade de documentos passados via POST
        if(count($input['documents']) == 1){
           $isWave = 0;
        }else{
           $isWave = 1;
        }

        //Recebe as informações do(s) documento(s) || Normal = 1 , Onda = Vários
        $documents = $input['documents'];

        //Valida se usuário possui permissão para liberar documento (ex: documents_prod_lib)
        if(App\Models\User::getPermission('documents_'.$module.'_lib',Auth::user()->user_type_code)){
            $libDoc = App\Models\Document::liberate($documents, $module, $isWave); 
            if($libDoc['erro'] <> 0){
                //Erro na liberação
                Flash::error($libDoc['msg']);
                return array('danger',$libDoc['msg']);
            }else{
                //Sucesso na liberação
                Flash::success($libDoc['msg']);
                return array('success', $libDoc['msg']);
            }
        }else{
            Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }

        
    }

    /**
     * Realiza o estorno de um documento
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function return($module, Request $request)
    {
        $input = $request->all();

        //Recebe as informações do(s) documento(s) || Normal = 1 , Onda = Vários
        $documents = $input['documents'];

        //Valida se usuário possui permissão para retornar documento (ex: documents_prod_ret)
        if(App\Models\User::getPermission('documents_'.$module.'_ret',Auth::user()->user_type_code)){
            $retDoc = App\Models\Document::return($documents, $module); 
            if($retDoc['erro'] <> 0){
                //Erro no retorno
                Flash::error($retDoc['msg']);
                return array('danger',$retDoc['msg']);
            }else{
                //Sucesso no retorno

                Flash::success($retDoc['msg']);
                return array('success',$retDoc['msg']);
            }

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }


    }

     /**
     * Realiza o cancelamento de um documento
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($module, Request $request)
    {
        $input = $request->all();

        //Recebe as informações do(s) documento(s) || Normal = 1 , Onda = Vários
        $documents = $input['documents'];

        //Valida se usuário possui permissão para retornar documento (ex: documents_prod_ret)
        if(App\Models\User::getPermission('documents_'.$module.'_ret',Auth::user()->user_type_code)){
            $retDoc = App\Models\Document::cancel($documents, $module); 
            if($retDoc['erro'] <> 0){
                //Erro no cancelamento
                Flash::error($retDoc['msg']);
                return array('danger',$retDoc['msg']);
            }else{
                //Sucesso no Cancelamento
                Flash::success($retDoc['msg']);
                return array('success',$retDoc['msg']);
            }

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }


    }

}
