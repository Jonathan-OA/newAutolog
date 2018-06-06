<?php

namespace App\Repositories;

use App\Models\AllowedTransfer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AllowedTransferRepository
 * @package App\Repositories
 * @version May 30, 2018, 4:43 pm -03
 *
 * @method AllowedTransfer findWithoutFail($id, $columns = ['*'])
 * @method AllowedTransfer find($id, $columns = ['*'])
 * @method AllowedTransfer first($columns = ['*'])
*/
class AllowedTransferRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'orig_department_code',
        'orig_deposit_code',
        'dest_department_code',
        'dest_deposit_code',
        'operation_code',
        'document_type_code',
        'reset_stock',
        'export_erp',
        'operation_erp',
        'cost_center',
        'logical_deposit',
        'enabled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AllowedTransfer::class;
    }
}
