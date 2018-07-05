<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentItem extends Model
{
    protected $table = 'document_items';

    protected $fillable = [
        'company_id','document_id','product_code','uom_code','qty', 'status'
    ];

    /**
     * Função que retorna todos os itens válidos de um documento
     * Parâmetros: ID do Documento 
     * @var array
     */

    public static function getItens($document_id){
        $itens = DocumentItem::where([ ['document_id', $document_id],
                                       ['status','<>',9]
                                    ])
                             ->get()
                             ->toArray();

        return $itens;

    }

}
