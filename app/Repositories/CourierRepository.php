<?php

namespace App\Repositories;

use App\Models\Courier;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CourierRepository
 * @package App\Repositories
 * @version March 13, 2018, 3:24 pm -03
 *
 * @method Courier findWithoutFail($id, $columns = ['*'])
 * @method Courier find($id, $columns = ['*'])
 * @method Courier first($columns = ['*'])
*/
class CourierRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'company_id',
        'name',
        'trading_name',
        'cnpj',
        'state_registration',
        'address',
        'number',
        'neighbourhood',
        'city',
        'state',
        'country',
        'zip_code',
        'phone1',
        'phone2',
        'status',
        'obs1',
        'obs2',
        'obs3'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Courier::class;
    }
}
