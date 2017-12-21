<?php

namespace App\Repositories;

use App\Models\DepositType;
use InfyOm\Generator\Common\BaseRepository;

class DepositTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DepositType::class;
    }
}
