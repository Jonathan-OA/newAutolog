<?php

namespace App\Models;

use Eloquent as Model;
use Auth;


/**
 * Class Notification
 * @package App\Models
 * @version August 16, 2018, 10:24 am -03
 *
 * @property \Illuminate\Database\Eloquent\Collection blockedOperations
 * @property \Illuminate\Database\Eloquent\Collection deposits
 * @property \Illuminate\Database\Eloquent\Collection layouts
 * @property \Illuminate\Database\Eloquent\Collection logs
 * @property \Illuminate\Database\Eloquent\Collection palletItems
 * @property \Illuminate\Database\Eloquent\Collection parameters
 * @property \Illuminate\Database\Eloquent\Collection userPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection vehicles
 * @property \Illuminate\Database\Eloquent\Collection volumes
 * @property string message
 */
class Notification extends Model
{
    public $table = 'notifications';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	
	
    public $fillable = [
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'message' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    

     //Retorna todos os notifications disponíveis
     public static function getNotifications(){
        return Notification::select("id", "message")
                      ->pluck('description_f','code');
    }

    /**
     * Função que retorna a ultima notificação para o usuário
     * Parâmetros: Filial e Código de Usuário
     * @var array
     */
    public static function getLastNotification($user_code){
        $lastNotf = Notification::select('id','message')->orderBy('id', 'desc')->first();
        $lastNotfUser = User::select('last_notification')
                                       ->where([
                                                 ['company_id', Auth::user()->company_id],
                                                 ['code',$user_code],
                                                 ['status', 1]
                                       ])
                                       ->first();
        //Retorna id da ultima notificação, ultima notificação lida pelo usuario e mensagem da ultima notificação                                
        return [$lastNotf->id,$lastNotf->message,$lastNotfUser->last_notification];

    }


}
