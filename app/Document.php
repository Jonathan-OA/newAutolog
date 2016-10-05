<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'company_id','number','document_type_id', 'emission_date', 'invoice'
    ];
}
