<?php

namespace App\Repositories;

use App\Models\InventoryStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class InventoryStatusRepository
 * @package App\Repositories
 * @version January 30, 2019, 11:16 am -02
 *
 * @method InventoryStatus findWithoutFail($id, $columns = ['*'])
 * @method InventoryStatus find($id, $columns = ['*'])
 * @method InventoryStatus first($columns = ['*'])
*/
class InventoryStatusRepository extends BaseRepository
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
        return InventoryStatus::class;
    }
}
