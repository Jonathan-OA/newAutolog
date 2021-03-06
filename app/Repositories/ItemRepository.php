<?php

namespace App\Repositories;

use App\Models\Item;
use InfyOm\Generator\Common\BaseRepository;

class ItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'code',
        'description',
        'status',
        'item_type_code',
        'group_code',
        'subgroup_code',
        'margin_div',
        'cost',
        'phase_code',
        'abz_code',
        'inventory_date',
        'due_date',
        'critical_date1',
        'critical_date2',
        'critical_date3',
        'ripeness_date',
        'obs1',
        'obs2',
        'obs3',
        'obs4',
        'obs5'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Item::class;
    }
}
