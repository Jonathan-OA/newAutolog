<?php

namespace App\Repositories;

use App\Models\LabelStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LabelStatusRepository
 * @package App\Repositories
 * @version June 7, 2018, 5:47 pm -03
 *
 * @method LabelStatus findWithoutFail($id, $columns = ['*'])
 * @method LabelStatus find($id, $columns = ['*'])
 * @method LabelStatus first($columns = ['*'])
*/
class LabelStatusRepository extends BaseRepository
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
        return LabelStatus::class;
    }
}
