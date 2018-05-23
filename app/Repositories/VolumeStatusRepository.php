<?php

namespace App\Repositories;

use App\Models\VolumeStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VolumeStatusRepository
 * @package App\Repositories
 * @version May 23, 2018, 4:09 pm -03
 *
 * @method VolumeStatus findWithoutFail($id, $columns = ['*'])
 * @method VolumeStatus find($id, $columns = ['*'])
 * @method VolumeStatus first($columns = ['*'])
*/
class VolumeStatusRepository extends BaseRepository
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
        return VolumeStatus::class;
    }
}
