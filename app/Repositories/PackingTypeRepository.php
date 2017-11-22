<?php

namespace App\Repositories;

use App\Models\PackingType;
use InfyOm\Generator\Common\BaseRepository;

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
