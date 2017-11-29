<?php

namespace App\Repositories;

use App\Models\ProductType;
use InfyOm\Generator\Common\BaseRepository;

class ProductTypeRepository extends BaseRepository
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
        return ProductType::class;
    }
}
