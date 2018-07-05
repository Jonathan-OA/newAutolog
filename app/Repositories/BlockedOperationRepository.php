<?php

namespace App\Repositories;

use App\Models\BlockedOperation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BlockedOperationRepository
 * @package App\Repositories
 * @version July 5, 2018, 4:17 pm -03
 *
 * @method BlockedOperation findWithoutFail($id, $columns = ['*'])
 * @method BlockedOperation find($id, $columns = ['*'])
 * @method BlockedOperation first($columns = ['*'])
*/
class BlockedOperationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'operation_code',
        'product_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BlockedOperation::class;
    }
}
