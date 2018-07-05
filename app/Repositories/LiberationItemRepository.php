<?php

namespace App\Repositories;

use App\Models\LiberationItem;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LiberationItemRepository
 * @package App\Repositories
 * @version July 5, 2018, 3:25 pm -03
 *
 * @method LiberationItem findWithoutFail($id, $columns = ['*'])
 * @method LiberationItem find($id, $columns = ['*'])
 * @method LiberationItem first($columns = ['*'])
*/
class LiberationItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'document_id',
        'document_item_id',
        'product_code',
        'pallet_id',
        'label_id',
        'qty',
        'liberation_status_id',
        'orig_location_code',
        'dest_location_code',
        'task_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LiberationItem::class;
    }
}
