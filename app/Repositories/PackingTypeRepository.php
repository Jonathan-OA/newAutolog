<?php

namespace App\Repositories;

use App\Models\PackingType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PackingTypeRepository
 * @package App\Repositories
 * @version March 2, 2018, 1:51 pm -03
 *
 * @method PackingType findWithoutFail($id, $columns = ['*'])
 * @method PackingType find($id, $columns = ['*'])
 * @method PackingType first($columns = ['*'])
*/
class PackingTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description',
        'tare',
        'capacity_kg',
        'capacity_m3',
        'capacity_un',
        'height',
        'width',
        'lenght'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PackingType::class;
    }
}
