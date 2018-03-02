<?php

namespace App\Repositories;

use App\Models\Moviment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MovimentRepository
 * @package App\Repositories
 * @version March 1, 2018, 7:25 pm UTC
 *
 * @method Moviment findWithoutFail($id, $columns = ['*'])
 * @method Moviment find($id, $columns = ['*'])
 * @method Moviment first($columns = ['*'])
*/
class MovimentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Moviment::class;
    }
}
