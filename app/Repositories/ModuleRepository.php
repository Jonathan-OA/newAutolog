<?php

namespace App\Repositories;

use App\Models\Module;
use InfyOm\Generator\Common\BaseRepository;

class ModuleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'module',
        'submodule',
        'name',
        'enabled',
        'icon',
        'url'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Module::class;
    }
}
