<?php

namespace App\Repositories;

use App\Models\LocationType;
use InfyOm\Generator\Common\BaseRepository;

class LocationTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description',
        'capacity_kg',
        'capacity_m3',
        'capacity_qty',
        'length',
        'width',
        'height'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LocationType::class;
    }
}
