<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App;
use DB;

class Document extends Model
{

    protected $table = 'documents';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'company_id',
        'number',
        'customer_code',
        'supplier_code',
        'courier_code',
        'invoice',
        'serial_number',
        'emission_date',
        'start_date',
        'end_date',
        'wave',
        'total_volumes',
        'total_weight',
        'document_status_id',
        'total_net_weigth',
        'driver_id',
        'vehicle_id',
        'priority',
        'comments',
        'document_type_code',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'number' => 'string',
        'company_id' => 'integer',
        'document_type_code' => 'string',
        'document_status_id' => 'integer',
        'customer_code' => 'string',
        'courier_code' => 'string',
        'supplier_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
    /**
     * Função que retorna todos os documentos de um tipo de movimento
     * Parâmetros: Código do Movimento e quantidade de documentos para retornar
     * @var array
     */

    public static function getDocuments($moviment_code, $qty){
        $docs = Document::select('documents.id','company_id','number','document_type_code','customer_code',
                                 'supplier_code','courier_code','vehicle_id','driver_id','invoice','serial_number',
                                 'emission_date','start_date','end_date','wave','total_volumes','total_weight',
                                 'document_status_id','total_net_weigth','priority','comments','user_id',
                                 'documents.created_at','documents.updated_at','moviment_code')
                       ->join('document_types', 'documents.document_type_code', '=', 'document_types.code')
                       ->where([
                                 ['documents.company_id', Auth::user()->company_id],
                                 ['document_types.moviment_code', $moviment_code]                        
                       ])
                       ->orderBy('documents.id', 'desc')
                       ->take($qty)
                       ->get();
        return $docs;
    }

    /**
     * Função que valida se o número de documento + tipo já existe (Para criação e importação)
     * Parâmetros: Tipo e Número do documento
     * @var array
     */

    public static function valDocumentNumber($document_type_code, $number){
        //Número só é valido se não existir nenhum documento com status <> 7, 8  e 9
        $docCount = Document::where([
                                 ['company_id', Auth::user()->company_id],
                                 ['document_type_code', $document_type_code],
                                 ['number', $number]
                            ])
                            ->whereNotIn('document_status_id',['7','8','9'])
                            ->count();
        return $docCount;
    }


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
                                 ['documents.id', $document_id],
                                 ['documents.document_status_id', 0]

                       ])
                       ->get();
                       
        //Valida se achou o documento
        if(count($doc) > 0){
            
            //Switch para definir qual classe de liberação será utilizada no documento baseado no movimento
            switch($doc[0]->moviment_code){
                
                //Recebimento
                case '010':
                    $class = 'App\Models\RulesReceipt';
                    $urlRet = 'receipt'; //Rota para retornar após a liberação
                    break;

                //Transferência
                case '020':
                    $class = 'App\Models\RulesTransf';
                    $urlRet = 'transference'; //Rota para retornar após a liberação
                    break;

                //Produção
                case '030':
                    $class = 'App\Models\RulesProduction';
                    $urlRet = 'production'; //Rota para retornar após a liberação
                    break;

                //Separação
                case '070':
                    $class = 'App\Models\RulesSeparation';
                    $urlRet = 'separation'; //Rota para retornar após a liberação
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
                //Deu tudo certo, da o commit
                DB::commit();

                //Grava log
                $descricao = 'Liberou o documento: '.$doc[0]->document_type_code.' - '.$doc[0]->number.' ('.$document_id.')';
                $log = App\Models\Log::wlog('documents_lib', $descricao);

                $return['erro'] = 0;
                $return['msg'] = 'Documento liberado com sucesso!';
                $return['urlRet'] = $urlRet;

            }else{
                $return['urlRet'] = $urlRet;
            }
            
        }else{
            $return['erro'] = 1;
            $return['msg'] = 'Erro ao liberar o documento.';

        }

        return $return;

    }

    /**
     * Função que retorna o documento para pendente
     * Parâmetros: ID do Documento 
     * @var array
     */

    public static function return($document_id){
        $doc = App\Models\Document::find($document_id);
        $doc->document_status_id = 0;
        $doc->save();
        //Apaga informaçoes da tabela de liberação
        $rLb = DB::table('liberation_itens')->where([  
                                                     ['company_id', Auth::user()->company_id],
                                                     ['document_id', $document_id]
                                           ])->delete();

        $rSt = DB::table('stocks')->where([  
                                                    ['company_id', Auth::user()->company_id],
                                                    ['document_id', $document_id],
                                                    ['finality_code', 'RESERVA']
                                            ])->delete();                                   
        
        $return['erro'] = 0;
        $return['msg'] = 'Documento retornado com sucesso!';
        $return['urlRet'] = $urlRet;
        
    }
}
