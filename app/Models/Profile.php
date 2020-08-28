<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
 
class Profile extends Model
{
    public $table = 'profiles';
    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'company_id',
        'type',
        'description',
        'delimiter',
        'format', 
        'created_at'
    ];

     //Retorna todos os profiles disponíveis para aquele tipo (IMPORT ou EXRPOT)
     public static function getProfiles($type){

        return Profile::where('type', $type)
                      ->where('company_id', Auth::user()->company_id)
                      ->get()
                      ->toArray();
                     
    }
}
