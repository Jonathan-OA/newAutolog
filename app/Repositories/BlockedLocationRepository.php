<?php

namespace App\Repositories;

use App\Models\BlockedLocation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BlockedLocationRepository
 * @package App\Repositories
 * @version July 5, 2018, 4:08 pm -03
 *
 * @method BlockedLocation findWithoutFail($id, $columns = ['*'])
 * @method BlockedLocation find($id, $columns = ['*'])
 * @method BlockedLocation first($columns = ['*'])
*/
class BlockedLocationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'location_code',
        'product_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BlockedLocation::class;
    }
}
