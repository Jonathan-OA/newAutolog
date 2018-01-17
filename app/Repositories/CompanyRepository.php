<?php

namespace App\Repositories;

use App\Models\Company;
use InfyOm\Generator\Common\BaseRepository;

class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'branch',
        'name',
        'cnpj',
        'trading_name',
        'address',
        'number',
        'neighbourhood',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }
}
