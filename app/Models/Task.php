<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use Carbon\Carbon;


/**
 * Class Task
 * @package App\Models
 * @version August 22, 2018, 2:59 pm -03
 *
 * @property \App\Models\Company company
 * @property \App\Models\DocumentItem documentItem
 * @property \App\Models\Document document
 * @property \Illuminate\Database\Eloquent\Collection Activity
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection Label
 * @property \Illuminate\Database\Eloquent\Collection layouts
 * @property \Illuminate\Database\Eloquent\Collection LiberationItem
 * @property \Illuminate\Database\Eloquent\Collection logs
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property integer company_id
 * @property string operation_code
 * @property string|\Carbon\Carbon start_date
 * @property string|\Carbon\Carbon end_date
 * @property bigInteger document_id
 * @property bigInteger document_item_id
 * @property string orig_location_code
 * @property string dest_location_code
 */
class Task extends Model
{
    public $table = 'tasks';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'operation_code',
        'start_date',
        'end_date',
        'document_id',
        'document_item_id',
        'orig_location_code',
        'dest_location_code',
        'task_status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'operation_code' => 'string',
        'orig_location_code' => 'string',
        'dest_location_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Função construtora
    public static function new($operation_code, $orig = null, $dest = null, $document_id = null, $document_item_id = null ){
        $task = new Task();
        $task->company_id = Auth::user()->company_id;
        $task->operation_code = $operation_code;
        $task->document_id = $document_id;
        $task->document_item_id = $document_item_id;
        $task->orig_location_code = $orig;
        $task->dest_location_code = $dest;
        $task->task_status_id = 0;
        $task->save();
        return $task;
    }

    /**
     * Função que inicia uma tarefa
     * Parâmetros: ID
     * @var array
     */
    public function start(){
        
        $this->task_status_id = 1;
        $this->start_date = Carbon::now();
        $this->save();
    }

    /**
     * Função que finaliza uma tarefa
     * Parâmetros: ID
     * @var array
     */
    public function end(){
        $data = Carbon::now();
        $this->task_status_id = 8;
        //Se data inicio não esta preenchida, preenche com o mesmo valor
        if(empty($this->start_date)){
            $this->start_date = $data;
        }
        $this->end_date = $data;
        $this->save();
    }

     //Retorna todos os tasks disponíveis
     public static function getTasks(){
        return Task::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
