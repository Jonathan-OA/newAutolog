<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use DB;
use Input;
use Auth;
use Schema;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    private $hasComp = '';

    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    /**
     * Filtra resultados de uma model para autocomplete
     *
     * @param  varchar $term, $table
     *
     * @return Response
     */

    public function autocomplete(){

        //Busca na tabela $table os registros com o código $term e o filtro $valDep (Caso seja um valor atrelado)
        $term = Input::get('term'); //String de pesquisa
        $table = Input::get('table'); //Tabela Atual
        $tableDep = Input::get('tableDep'); //Valor de um input dependente
        $field = (trim($tableDep) == '' || Input::get('field') == substr($table,0,-1).'_code')? 'code' : Input::get('field'); //Nome do Campo de Busca
        
        //Caso seja campos de Origem/Destino, considera o campo code
        if(strpos($field,'orig') !== false || strpos($field,'dest') !== false ){
            $field = 'code';
        }elseif(strpos($field,'prev') !== false){
            $field = substr($field,5);
        }

        

        $GLOBALS['valDep'] = Input::get('valDep');
        $GLOBALS['campoDep'] = substr($tableDep,0,-1).'_code';

        $results = array();
        
        //Só busca caso a tabela tenha o campo Company_Id
        $GLOBALS['hasComp'] = (Schema::hasColumn($table, 'company_id'))?1:0;
        $queries = DB::table($table)
            ->where($field, 'LIKE', '%'.$term.'%')
            ->where(function ($query) {
                        if($GLOBALS['hasComp'] == 1){
                            $query->where('company_id',Auth::user()->company_id);
                        }
                   })
            ->where(function ($query) {
                    //Valida se o select deve considerar campo atrelado como filtro
                    if(trim($GLOBALS['valDep']) <> ''){
                        $query->where($GLOBALS['campoDep'],$GLOBALS['valDep']);
                    }
            })
            ->orderBy($field, 'asc')
            ->take(12)->get();

        //Se tiver o campo descrição/nome na tabela, concatena na label
        $hasDesc = (Schema::hasColumn($table, 'description'))?1:0;
        $hasName = (Schema::hasColumn($table, 'name'))?1:0;

        
        foreach ($queries as $query)
        {
            if($hasDesc == 1){
                //Se possui o campo descrição na tabela, concatena no texto que aparece para o usuário
                $desc = ' - '.$query->description;
            }elseif($hasName == 1){
                //Se possui o campo name na tabela, concatena no texto que aparece para o usuário
                $desc = ' - '.$query->name;
            }else{
                $desc = '';
            }
            $results[] = [ 'id' => $query->id, 'value' => $query->$field, 'label' => $query->$field.$desc ];
        }
        
        return Response::json($results);
    }
}
