<?php

namespace App\Repositories;

use App\Models\Document;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DocumenttRepository
 * @package App\Repositories
 * @version July 11, 2018, 4:49 pm -03
 *
 * @method Documentt findWithoutFail($id, $columns = ['*'])
 * @method Documentt find($id, $columns = ['*'])
 * @method Documentt first($columns = ['*'])
*/
class DocumentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'number',
        'customer_code',
        'supplier_code',
        'courier_code',
        'invoice',
        'serial_number',
        'emission_date',
        'start_date',
        'end_date',
        'wave',
        'total_volumes',
        'total_weight',
        'document_status_id',
        'total_net_weigth',
        'driver_id',
        'vehicle_id',
        'priority',
        'comments',
        'document_type_code',
        'user_id',
        'location_code',
        'number_origin',
        'document_type_origin',
        'delivery_date',
        'order_fields'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Document::class;
    }
}
