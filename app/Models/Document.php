<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Document extends Model
{
    protected $fillable = [
        'company_id',
        'number',
        'document_type_code', 
        'emission_date',
         'invoice', 
         'document_status_id'
    ];

    /**
     * Função que libera o documento encaminhando para as regras corretas de acordo com o tipo
     * Parâmetros: ID do Documento 
     * @var array
     */

    public static function liberate($document_id){

        $doc = Document::select('documents.number',
                                'documents.document_type_code',
                                'document_types.moviment')
                       ->join('document_types', 'documents.document_type_code', '=', 'document_types.code')
                       ->where([
                                 ['company_id', Auth::user()->company_id],
                                 ['document_id', $document_id]
                       ])
                       ->get();
                       print_r($doc);exit;
        switch($document_type_code){


        }


    }
}
