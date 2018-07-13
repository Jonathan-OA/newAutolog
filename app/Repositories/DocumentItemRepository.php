<?php

namespace App\Repositories;

use App\Models\DocumentItem;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DocumentItemRepository
 * @package App\Repositories
 * @version July 13, 2018, 5:41 pm -03
 *
 * @method DocumentItem findWithoutFail($id, $columns = ['*'])
 * @method DocumentItem find($id, $columns = ['*'])
 * @method DocumentItem first($columns = ['*'])
*/
class DocumentItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'document_id',
        'product_code',
        'qty',
        'uom_code',
        'document_status_id',
        'batch',
        'batch_supplier',
        'serial_number',
        'qty_conf',
        'qty_ship',
        'qty_reject',
        'invoice',
        'invoice_serial_number',
        'sequence_item',
        'umvcad_id',
        'location_code',
        'source',
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
        return DocumentItem::class;
    }
}
