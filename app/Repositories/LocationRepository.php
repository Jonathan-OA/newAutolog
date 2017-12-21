<?php

namespace App\Repositories;

use App\Models\Location;
use InfyOm\Generator\Common\BaseRepository;

class LocationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'department_code',
        'deposit_code',
        'sector_code',
        'code',
        'barcode',
        'aisle',
        'column',
        'level',
        'depth',
        'status',
        'location_type_code',
        'location_function_code',
        'abz_code',
        'label_type_code',
        'stock_type',
        'sequence_arm',
        'sequence_sep',
        'sequence_inv'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Location::class;
    }
}
