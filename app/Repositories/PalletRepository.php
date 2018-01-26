<?php

namespace App\Repositories;

use App\Models\Pallet;
use InfyOm\Generator\Common\BaseRepository;

class PalletRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'barcode',
        'date',
        'status',
        'location_code',
        'document_id',
        'height',
        'stacking',
        'packing_type_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pallet::class;
    }
}
