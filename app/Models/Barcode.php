<?php

namespace App\Models;

use Eloquent as Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Barcode
 * @package App\Models
 * @version November 29, 2017, 4:00 pm UTC
 */
class Barcode extends Model
{
    public $table = 'barcodes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'company_id',
        'product_code',
        'barcode'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'product_code' => 'string',
        'barcode' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    
}
