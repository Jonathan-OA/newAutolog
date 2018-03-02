<?php

namespace App\Repositories;

use App\Models\Packing;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PackingRepository
 * @package App\Repositories
 * @version March 2, 2018, 1:40 pm -03
 *
 * @method Packing findWithoutFail($id, $columns = ['*'])
 * @method Packing find($id, $columns = ['*'])
 * @method Packing first($columns = ['*'])
*/
class PackingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'level',
        'product_code',
        'uom_code',
        'barcode',
        'prev_qty',
        'prev_level',
        'label_type_code',
        'total_weight',
        'total_net_weight',
        'lenght',
        'width',
        'depth',
        'total_m3',
        'stacking',
        'packing_type_code',
        'print_label',
        'create_label',
        'conf_batch',
        'conf_weight',
        'conf_serial',
        'conf_batch_supplier',
        'conf_due_date',
        'conf_prod_date',
        'conf_length',
        'conf_width',
        'conf_height'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Packing::class;
    }
}
