<?php

namespace App\Repositories;

use App\Models\Stock;
use InfyOm\Generator\Common\BaseRepository;

class StockRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'product_code',
        'label_id',
        'location_code',
        'qty',
        'uom_code',
        'prev_qty',
        'prev_uom_code',
        'pallet_id',
        'document_id',
        'document_item_id',
        'task_id',
        'finality',
        'user_id',
        'operation_code',
        'volume_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Stock::class;
    }
}
