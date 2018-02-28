<?php

namespace App\Repositories;

use App\Models\Finality;
use InfyOm\Generator\Common\BaseRepository;

class FinalityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Finality::class;
    }
}
