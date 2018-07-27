<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Grid
 * @package App\Models
 * @version July 27, 2018, 11:34 am -03
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property integer company_id
 * @property string module
 * @property string submodule
 * @property string columns
 */
class Grid extends Model
{
    public $table = 'grids';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'company_id',
        'module',
        'submodule',
        'columns'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'module' => 'string',
        'submodule' => 'string',
        'columns' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os grids disponíveis
     public static function getGrids(){
        return Grid::selectRaw("code,CONCAT(code,' - ',description) as description_f")
                      ->where('company_id', Auth::user()->company_id)
                      ->pluck('description_f','code');
    }


}
