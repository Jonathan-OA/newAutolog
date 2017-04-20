<?php

namespace App\Repositories;

use App\Models\Vehicles;
use InfyOm\Generator\Common\BaseRepository;

class VehiclesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'courier_id',
        'vehicle_type_id',
        'number_plate'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Vehicles::class;
    }
}
