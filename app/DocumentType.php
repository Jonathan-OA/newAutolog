<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = [
        'code','description','moviment_code'
    ];

    // Retorna os tipos de documentos para um movimento específico
    public static function getDocTypes($movimento){
        $tipos = DocumentType::where('moviment_code', "$movimento")->get();
        return $tipos;
    }

}
