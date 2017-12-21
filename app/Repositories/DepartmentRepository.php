<?php

namespace App\Repositories;

use App\Models\Department;
use InfyOm\Generator\Common\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'code',
        'description',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Department::class;
    }
}
