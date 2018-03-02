<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'company_id','number','document_type_code', 'emission_date', 'invoice', 'document_status_id'
    ];

}
