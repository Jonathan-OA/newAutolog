<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'company_id',
        'code',
        'name',
        'password',
        'email',
        'user_type_code',
        'remember_token',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
