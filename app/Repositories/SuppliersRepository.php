<?php

namespace App\Repositories;

use App\Models\Suppliers;
use InfyOm\Generator\Common\BaseRepository;

class SuppliersRepository extends BaseRepository
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
        'obs3'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Suppliers::class;
    }
}
