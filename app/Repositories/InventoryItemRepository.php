<?php

namespace App\Repositories;

use App\Models\InventoryItem;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class InventoryItemRepository
 * @package App\Repositories
 * @version January 29, 2019, 2:58 pm -02
 *
 * @method InventoryItem findWithoutFail($id, $columns = ['*'])
 * @method InventoryItem find($id, $columns = ['*'])
 * @method InventoryItem first($columns = ['*'])
*/
class InventoryItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'document_id',
        'product_code',
        'pallet_id',
        'label_id',
        'location_code',
        'qty_wms',
        'inventory_status_id',
        'qty_1count',
        'user_1count',
        'date_1count',
        'qty_2count',
        'user_2count',
        'date_2count',
        'qty_3count',
        'user_3count',
        'date_3count',
        'qty_4count',
        'user_4count',
        'date_4count'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return InventoryItem::class;
    }
}
