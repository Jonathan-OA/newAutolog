<?php

namespace App\Repositories;

use App\Models\Supplier;
use InfyOm\Generator\Common\BaseRepository;

class SupplierRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'company_id',
        'name',
        'trading_name',
        'cnpj',
        'state_registration',
        'address',
        'number',
        'neighbourhood',
        'city',
        'state',
        'country',
        'zip_code',
        'phone1',
        'phone2',
        'active',
        'obs1',
        'obs2',
        'obs3',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Supplier::class;
    }
}
