<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentItem extends Model
{
    protected $table = 'document_items';

    protected $fillable = [
        'company_id','document_id','product_code','uom_code','qty', 'status'
    ];
}
