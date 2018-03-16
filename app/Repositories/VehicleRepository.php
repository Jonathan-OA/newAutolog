<?php

namespace App\Repositories;

use App\Models\Vehicle;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VehicleRepository
 * @package App\Repositories
 * @version March 13, 2018, 3:24 pm -03
 *
 * @method Vehicle findWithoutFail($id, $columns = ['*'])
 * @method Vehicle find($id, $columns = ['*'])
 * @method Vehicle first($columns = ['*'])
*/
class VehicleRepository extends BaseRepository
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
        return Vehicle::class;
    }
}
