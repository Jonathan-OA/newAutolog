<?php

namespace App\Repositories;

use App\Models\UserType;
use InfyOm\Generator\Common\BaseRepository;

class UserTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserType::class;
    }
}
