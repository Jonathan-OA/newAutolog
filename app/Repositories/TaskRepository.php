<?php

namespace App\Repositories;

use App\Models\Task;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TaskRepository
 * @package App\Repositories
 * @version August 22, 2018, 2:59 pm -03
 *
 * @method Task findWithoutFail($id, $columns = ['*'])
 * @method Task find($id, $columns = ['*'])
 * @method Task first($columns = ['*'])
*/
class TaskRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'operation_code',
        'start_date',
        'end_date',
        'document_id',
        'document_item_id',
        'orig_location_code',
        'dest_location_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Task::class;
    }
}
