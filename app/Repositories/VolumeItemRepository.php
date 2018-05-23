<?php

namespace App\Repositories;

use App\Models\VolumeItem;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VolumeItemRepository
 * @package App\Repositories
 * @version March 28, 2018, 4:06 pm -03
 *
 * @method VolumeItem findWithoutFail($id, $columns = ['*'])
 * @method VolumeItem find($id, $columns = ['*'])
 * @method VolumeItem first($columns = ['*'])
*/
class VolumeItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'volume_id',
        'product_code',
        'qty',
        'uom_code',
        'prim_qty',
        'prim_uom_code',
        'label_id',
        'activity_id',
        'status',
        'turn'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return VolumeItem::class;
    }
}
