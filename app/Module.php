<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    //Tabela relacionada aos modulos do sistema (menu)
    protected $table = 'modules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name','enabled','url','module','submodule'
    ];

    


}
