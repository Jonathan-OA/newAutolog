<?php

namespace App\Models;
use App;
use DB;

use Illuminate\Database\Eloquent\Model;

class RulesReceipt extends Model
{

    // Regra Base - Valida se o documento possui itens
    public static function rec000($document_id){
        //Retorna itens que não estejam cancelados para o documento
        $itens = App\Models\DocumentItem::getItens($document_id, 9);
        if(count($itens) == 0){
            $ret['erro'] = 1;
            $ret['msg'] = 'Sem itens para liberar';
        }else{
            $ret['erro'] = 0;
            $ret['msg'] = '';
        }
        return $ret;
    }

    // Cria tarefa de recebimento
    public static function rec001($document_id){
        //Pega informações do documento
        $document = App\Models\Document::find($document_id);
        
        if($document->count() == 0){
            $ret['erro'] = 1;
            $ret['msg'] = 'Erro ao Localizar Documento';
        }else{
            $ret['erro'] = 0;
            $ret['msg'] = '';
        }
        //Pega informações do tipo de documento
        $docType = App\Models\DocumentType::where('code', $document->document_type_code)->get()->toArray();
        
        //Pega tarefa de recebimento (operation_code na tabela document_types)
        $taskRec = (trim($docType[0]['operation_code']) == '') ? '679' : $docType[0]['operation_code'];

        //Pega endereço saldo na sessão na hora de liberação
        $location = (!empty($_SESSION['location_code_lib']) ? $_SESSION['location_code_lib'] : 'REC');

        //Cria tarefa e inicia
        $newTask = App\Models\Task::create($taskRec, $location, $location, $document_id);
        $newTask->start();

        return $ret;
    }

    
}
