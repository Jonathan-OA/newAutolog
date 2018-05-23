<?php

namespace App\Repositories;

use App\Models\PalletStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PaleteStatusRepository
 * @package App\Repositories
 * @version May 23, 2018, 4:16 pm -03
 *
 * @method PalletStatus findWithoutFail($id, $columns = ['*'])
 * @method PalletStatus find($id, $columns = ['*'])
 * @method PalletStatus first($columns = ['*'])
*/
class PaleteStatusRepository extends BaseRepository
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
        return PalletStatus::class;
    }
}
