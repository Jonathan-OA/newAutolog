<?php

namespace App\Models;


use Eloquent as Model;
use Auth;
use App\Repositories\LabelRepository;


/**
 * Class Label
 * @package App\Models
 * @version February 27, 2018, 10:48 am BRT
 */
class Label extends Model
{
    public $table = 'labels';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    private $labelRepository;

    protected $dates = ['due_date','prod_date','deleted_at','ripeness_date','critical_date1','critical_date2','critical_date3',];


    public $fillable = [
        'company_id',
        'barcode',
        'product_code',
        'qty',
        'uom_code',
        'prim_qty',
        'prim_uom_code',
        'document_id',
        'document_item_id',
        'origin',
        'date',
        'serial_number',
        'batch',
        'batch_supplier',
        'prod_date',
        'due_date',
        'user_id',
        'ripeness_date',
        'critical_date1',
        'critical_date2',
        'critical_date3',
        'label_status_id',
        'level',
        'travel_id',
        'task_id',
        'label_type_code',
        'weight',
        'width',
        'lenght',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'barcode' => 'string',
        'product_code' => 'string',
        'uom_code' => 'string',
        'prim_uom_code' => 'stdring',
        'serial_number' => 'string',
        'batch' => 'string',
        'batch_supplier' => 'string',
        'label_type_code' => 'string',
        'text1' => 'string',
        'text2' => 'string',
        'text3' => 'string',
        'text4' => 'string',
        'text5' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

     /**
     * Função que cria uma label de acordo com os parâmetros informados
     *
     * @var array
     */
    public static function createLabel($infos){
        $infos['company_id'] = Auth::user()->company_id;
        $infos['barcode'] = Auth::user()->id.date('YmsHis'); //Padrão do Barcode é Usuario + Data
        $infos['user_id'] = Auth::user()->id;
        $infos['qty'] = (empty($infos['qty']))? 1 : $infos['qty'];
        $infos['prim_qty'] = (empty($infos['prim_qty']))? 1 : $infos['prim_qty'];

        //Classe pai Model::create()
        $label = parent::create($infos);
        if($label){
            //Cria barcode com ID completando com zeros (totalizando 13)
            $label->barcode = str_pad($label->id,13,'0',STR_PAD_LEFT);
            $label->save();
        }
        
        return $label;
    }


    /**
     * Função de Rastreabilidade de Etiquetas
     *
     * @var array
     */
    public static function getTraceability($label_id){
        return Activity::select('labels.barcode', 'tasks.operation_code', 'activities.start_date', 'tasks.orig_location_code',
                                'tasks.dest_location_code', 'pallets.barcode as plt_barcode','users.code as user_code',
                                'operations.description','activities.qty','activities.uom_code')
                       ->join('tasks', 'tasks.id', 'activities.task_id')
                       ->join('users', 'users.id', 'activities.user_id')
                       ->join('labels', 'labels.id', 'activities.label_id')
                       ->join('operations', 'operations.code', 'tasks.operation_code')
                       ->leftJoin('pallets', 'pallets.id', 'activities.pallet_id')
                       ->leftJoin('documents', 'documents.id', 'activities.document_id')
                       ->where([ ['activities.label_id', $label_id],
                                 ['activities.activity_status_id', '<>', 0], 
                                 ['activities.company_id', '=', Auth::user()->company_id]
                               ] 
                       )
                       ->orderBy('start_date', 'asc')
                       ->get();
    }


    /**
     * Função que retorna informações para impressão (em formato de array)
     *
     * @param label_id
     * @var array
     */
    public static function getInfosForPrint($label_id, $variablesList = array()){

        if(count($variablesList) == 0){
            $infos = Label::select('labels.barcode as labels.barcode', 'labels.qty as labels.qty',
                                   'labels.uom_code as labels.uom_code','labels.prim_qty as labels.prim_qty',
                                   'labels.prim_uom_code as labels.prim_uom_code','labels.batch as labels.batch',
                                   'labels.batch_supplier as labels.batch_supplier','labels.serial_number as labels.serial_number',
                                   'labels.prod_date as labels.prod_date','labels.due_date as labels.due_date',
                                   'labels.width as labels.width','labels.length as labels.length',
                                   'labels.obs1 as labels.obs1','labels.obs2 as labels.obs2',
                                   'labels.obs3 as labels.obs3','labels.obs4 as labels.obs4',
                                   'label_status.description as label_status.description',
                                   'labels_origin.barcode as labels.origin','documents.number as documents.number',
                                   'documents.document_type_code as documents.document_type_code','products.code as products.code',
                                   'products.description as  products.description')
                            ->join('products', function ($join) {
                                        $join->on('products.code','labels.product_code')
                                            ->whereColumn('products.company_id','labels.company_id');
                                })
                            ->join('label_status', 'label_status.id', 'labels.label_status_id')
                            ->leftJoin('labels as labels_origin', 'labels_origin.id', 'labels.origin')
                            ->leftJoin('documents', 'documents.id', 'labels.document_id')
                            ->leftJoin('document_items', 'document_items.id', 'labels.document_item_id')
                            ->leftJoin('customers', function ($join) {
                                    $join->on('customers.code','documents.customer_code')
                                        ->whereColumn('customers.company_id','documents.company_id');
                            })
                            ->where('labels.id', $label_id)
                            ->where('labels.label_status_id','<>','9')
                            ->get(); 
        }else{
            //Faz loop na lista de variáveis para montar o select dinâmico e um array com as tabelas para os joins
            $selectFields = '';
            $arrayTables = array();
            foreach($variablesList as $val){
                $selectFields .= $val['table'].'.'.$val['field']." as ".$val['table'].'.'.$val['field']."','";
                $arrayTables[] = $val['table'];
            }

            //Retira última vírgula
            $selectFields = substr($selectFields,0,-1);
            $infos = Label::select($selectFields)
                            ->join('products', function ($join) {
                                        $join->on('products.code','labels.product_code')
                                            ->whereColumn('products.company_id','labels.company_id');
                            });

            //Realiza os joins de acordo com as tabelas informadas no cadastro das variáveis                
            if(in_array('documents', $arrayTables)){
                $infos->leftJoin('documents', 'documents.id', 'labels.document_id');
            }

            if(in_array('document_items', $arrayTables)){
                $infos->leftJoin('document_items', 'document_items.id', 'labels.document_item_id');
            }
            
            if(in_array('label_status', $arrayTables)){
                $infos->join('label_status', 'label_status.id', 'labels.label_status_id');
            }

            if(in_array('labels_origin', $arrayTables)){
                $infos->leftJoin('labels as labels_origin', 'labels_origin.id', 'labels.origin');
            }
            

            if(in_array('customers', $arrayTables)){
                $infos->leftJoin('customers', function ($join) {
                            $join->on('customers.code','documents.customer_code')
                                 ->whereColumn('customers.company_id','documents.company_id');
                });
            }


            $infos->where('labels.id', 1)
                  ->where('labels.label_status_id','<>','9')
                  ->get()
                  ->toArray();

                  //print_r($infos);exit;

        }
        //Formata os campos de data
        //$infos->labels.due_date->format('d/m/Y'); //Validade
        //$infos->labels.prod_date->format('d/m/Y'); //Produção
        
        return $infos;   

    }

    //Retorna todos os labels disponíveis
    public static function getLabels(){
        return Label::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
