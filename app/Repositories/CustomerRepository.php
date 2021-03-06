<?php

namespace App\Repositories;

use App\Models\Customer;
use InfyOm\Generator\Common\BaseRepository;

class CustomerRepository extends BaseRepository
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
        'due_days',
        'profile_import',
        'profile_export',
        'prefix_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }
}
