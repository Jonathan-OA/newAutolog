<?php

namespace App\Repositories;

use App\Models\ActivityStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ActivityStatusRepository
 * @package App\Repositories
 * @version January 30, 2019, 11:09 am -02
 *
 * @method ActivityStatus findWithoutFail($id, $columns = ['*'])
 * @method ActivityStatus find($id, $columns = ['*'])
 * @method ActivityStatus first($columns = ['*'])
*/
class ActivityStatusRepository extends BaseRepository
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
        return ActivityStatus::class;
    }
}
