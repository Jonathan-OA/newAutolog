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
        'cnpj',
        'address'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }
}
