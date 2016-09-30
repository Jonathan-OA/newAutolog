<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //Tabela relacionada a Model
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'code','branch','name','cnpj','trading_name'
    ];
}
