<?php

namespace App\Repositories;

use App\Models\Permission;
use InfyOm\Generator\Common\BaseRepository;

class PermissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'module',
        'active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
}
