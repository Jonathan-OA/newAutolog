<?php

namespace App\Repositories;

use App\Models\StockType;
use InfyOm\Generator\Common\BaseRepository;

class StockTypeRepository extends BaseRepository
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
        return StockType::class;
    }
}
