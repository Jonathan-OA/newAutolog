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

        //Busca na tabela $table os registros com o código $term
        $term = Input::get('term');
        $table = Input::get('table');

        $results = array();
        
        //Só busca caso a tabela tenha o campo Company_Id
        $hasComp = (Schema::hasColumn($table, 'company_id'))?1:0;
        if($hasComp == 1){
            $queries = DB::table($table)
                ->where('code', 'LIKE', '%'.$term.'%')
                ->where('company_id', Auth::user()->company_id)
                ->take(40)->get();

            //Se tiver o campo descrição na tabela, concatena na label
            $hasDesc = (Schema::hasColumn($table, 'description'))?1:0;
            
            foreach ($queries as $query)
            {
                $desc = ($hasDesc == 1)? ' - '.$query->description : '';
                $results[] = [ 'id' => $query->id, 'value' => $query->code, 'label' => $query->code.$desc ];
            }
        }
        return Response::json($results);
    }
}
