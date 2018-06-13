<?php

namespace App\Repositories;

use App\Models\BlockedProduct;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BlockedProductRepository
 * @package App\Repositories
 * @version June 12, 2018, 10:57 am -03
 *
 * @method BlockedProduct findWithoutFail($id, $columns = ['*'])
 * @method BlockedProduct find($id, $columns = ['*'])
 * @method BlockedProduct first($columns = ['*'])
*/
class BlockedProductRepository extends BaseRepository
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
        return BlockedProduct::class;
    }
}
