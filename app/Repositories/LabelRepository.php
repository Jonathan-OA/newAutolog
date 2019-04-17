<?php

namespace App\Repositories;

use App\Models\Label;
use InfyOm\Generator\Common\BaseRepository;

class LabelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'barcode',
        'product_code',
        'qty',
        'uom_code',
        'prev_qty',
        'prev_uom_code',
        'document_id',
        'document_item_id',
        'origin',
        'date',
        'serial_number',
        'batch',
        'batch_supplier',
        'prod_date',
        'due_date',
        'ripeness_date',
        'critical_date1',
        'critical_date2',
        'critical_date3',
        'label_status_id',
        'level',
        'travel_id',
        'task_id',
        'label_type_code',
        'weight',
        'width',
        'lenght',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Label::class;
    }
}
