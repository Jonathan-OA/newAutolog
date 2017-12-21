<?php

namespace App\Repositories;

use App\Models\LocationFunction;
use InfyOm\Generator\Common\BaseRepository;

class LocationFunctionRepository extends BaseRepository
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
        return LocationFunction::class;
    }
}
