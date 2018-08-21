<?php

namespace App\Repositories;

use App\Models\PalletItem;
use InfyOm\Generator\Common\BaseRepository;

class PalletItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'pallet_id',
        'product_code',
        'qty',
        'uom_code',
        'prev_qty',
        'prev_uom_code',
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
        return PalletItem::class;
    }
}
