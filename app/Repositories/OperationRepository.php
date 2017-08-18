<?php

namespace App\Repositories;

use App\Models\Operation;
use InfyOm\Generator\Common\BaseRepository;

class OperationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'type',
        'module',
        'level',
        'action',
        'description',
        'local',
        'writes_log',
        'enabled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Operation::class;
    }
}
