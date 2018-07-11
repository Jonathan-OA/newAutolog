<?php

namespace App\Repositories;

use App\Models\Documentt;
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
class DocumenttRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'number',
        'customer_id',
        'supplier_id',
        'courier_id',
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
        'document_type_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Documentt::class;
    }
}
