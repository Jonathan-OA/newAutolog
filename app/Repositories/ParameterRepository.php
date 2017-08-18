<?php

namespace App\Repositories;

use App\Models\Parameter;
use InfyOm\Generator\Common\BaseRepository;

class ParameterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'code',
        'description',
        'value',
        'def_value',
        'module_name',
        'operation_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Parameter::class;
    }
}
