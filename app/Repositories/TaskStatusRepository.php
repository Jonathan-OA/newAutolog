<?php

namespace App\Repositories;

use App\Models\TaskStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TaskStatusRepository
 * @package App\Repositories
 * @version August 22, 2018, 3:08 pm -03
 *
 * @method TaskStatus findWithoutFail($id, $columns = ['*'])
 * @method TaskStatus find($id, $columns = ['*'])
 * @method TaskStatus first($columns = ['*'])
*/
class TaskStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TaskStatus::class;
    }
}
