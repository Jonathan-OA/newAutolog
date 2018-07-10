<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App;
use DB;

class Document extends Model
{
    protected $fillable = [
        'company_id',
        'number',
        'document_type_code', 
        'emission_date',
         'invoice', 
         'document_status_id'
    ];

    /**
     * Função que libera o documento encaminhando para as regras corretas de acordo com o tipo
     * Parâmetros: ID do Documento 
     * @var array
     */

    public static function liberate($document_id){

        $doc = Document::select('documents.number',
                                'documents.document_type_code',
                                'document_types.moviment_code')
                       ->join('document_types', 'documents.document_type_code', '=', 'document_types.code')
                       ->where([
                                 ['documents.company_id', Auth::user()->company_id],
                                 ['documents.id', $document_id]
                       ])
                       ->get();
        //Valida se achou o documento
        if(count($doc) > 0){
            //Switch para definir qual classe de liberação será utilizada no documento baseado no movimento
            switch($doc[0]->moviment_code){
                //Recebimento
                case '010':
                    $class = 'App\Models\RulesProduction';
                    break;

                //Trânsferência
                case '020':
                    $class = 'RulesTransf';
                    break;

                //Produção
                case '030':
                    $class = 'RulesProduction';
                    break;

                //Separação
                case '070':
                    $class = 'RulesSep';
                    break;

            }

            $erro = 0;

            //Busca todas as regras disponíveis para o tipo de documento
            $rules = App\Models\DocumentTypeRule::where([
                                                            ['company_id', Auth::user()->company_id],
                                                            ['document_type_code', $doc[0]->document_type_code],
                                                 ])
                                                 ->orderBy('order', 'asc')
                                                 ->get()
                                                 ->toArray();
            DB::beginTransaction();
            foreach($rules as $rule){
                $rule_code = $rule['liberation_rule_code'];
                //Valida se existe a função com esse nome/código na classe correspondente
                if(method_exists(new $class(),$rule_code)){
                    //Chama a regra correspondente
                    $return = $class::$rule_code($document_id);
                    if($return['erro'] <> 0){
                        $erro = 1;
                        //Caso dê erro, desfaz tudo que foi inserido
                        DB::rollBack();
                        break;
                    }
                }else{
                    echo 'Regra '.$rule_code.' não existe no arquivo de liberação.';
                }
            }
            if($erro == 0){
                DB::commit();
            }else{
                echo $return['msg'];
            }
            
            
        }

    }
}
