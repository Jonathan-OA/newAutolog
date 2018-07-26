<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use DB;


/**
 * Class Graph
 * @package App\Models
 * @version July 25, 2018, 5:46 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string description
 * @property string type
 * @property string qry
 */
class Graph extends Model
{
    public $table = 'graphs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'description',
        'type',
        'qry'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'type' => 'string',
        'qry' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

     /**
     * Gera uma cor aleatóriamente
     *
     * 
     */
    function getColor() {
        $num = mt_rand( 0, 255);
        $hash = md5('color' . $num); // modify 'color' to get a different palette
        return hexdec(substr($hash, 4, 2)).','.hexdec(substr($hash, 10, 2)).','.hexdec(substr($hash, 12, 2));

    }

    /**
     * Retorna resultados dos gráficos cadastrados
     *
     * @var array
     */
    public static function getDataGraph($id){

        $ret = array();

        if($id == 1){
            $results = DB::table('documents')->join('document_status', 'document_status.id', 'documents.document_status_id')
                                        ->select(DB::raw('count(*) as qty'), 'description')
                                        ->where('company_id', Auth::user()->company_id)
                                        ->groupBy('description', 'document_status.id')
                                        ->orderBy('document_status.id')
                                        ->get();
            
            foreach($results as $res){
                
                $ret['labels'][] = $res->description;
                $ret['data'][] = $res->qty;
                $ret['color'][] =  "rgba(".(new self)->getColor().",0.5)";
                

            }        

            $ret['title'] = 'Num. de Documentos por Status';
            $ret['chartType'] = 'bar';
        }else{
            $results = DB::table('documents')->join('document_status', 'document_status.id', 'documents.document_status_id')
            ->join('document_types', 'document_types.code', 'documents.document_type_code')
            ->join('moviments', 'moviments.code', 'document_types.moviment_code')
            ->select(DB::raw('count(*) as qty'), 'moviments.description')
            ->where('company_id', Auth::user()->company_id)
            ->groupBy('moviments.description')
            ->orderBy('moviments.description')
            ->get();

            foreach($results as $res){

            $ret['labels'][] = $res->description;
            $ret['data'][] = $res->qty;
            $ret['color'][] =  "rgba(".(new self)->getColor().",0.5)";


            }        

            $ret['title'] = 'Num. de Documentos por Módulo';
            $ret['chartType'] = 'pie';
        }
        return $ret;
    
    
    
    }
        
    

    

     //Retorna todos os graphs disponíveis
     public static function getGraphs(){
        return Graph::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
