<?php

namespace App\Repositories;

use App\Models\Uom;
use InfyOm\Generator\Common\BaseRepository;

class UomRepository extends BaseRepository
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
        return Uom::class;
    }
}
