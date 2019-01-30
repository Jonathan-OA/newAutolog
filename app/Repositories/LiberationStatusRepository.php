<?php

namespace App\Repositories;

use App\Models\LiberationStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LiberationStatusRepository
 * @package App\Repositories
 * @version January 30, 2019, 11:16 am -02
 *
 * @method LiberationStatus findWithoutFail($id, $columns = ['*'])
 * @method LiberationStatus find($id, $columns = ['*'])
 * @method LiberationStatus first($columns = ['*'])
*/
class LiberationStatusRepository extends BaseRepository
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
        return LiberationStatus::class;
    }
}
