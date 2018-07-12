<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class DocumentStatus
 * @package App\Models
 * @version July 11, 2018, 11:51 pm -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property string description
 */
class DocumentStatus extends Model
{
    public $table = 'document_status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'id',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os document_status disponíveis
     public static function getDocumentStatus(){
        return DocumentStatus::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->pluck('description_f','code');
    }


}
