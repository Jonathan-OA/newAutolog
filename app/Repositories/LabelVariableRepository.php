<?php

namespace App\Repositories;

use App\Models\LabelVariable;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LabelVariableRepository
 * @package App\Repositories
 * @version May 8, 2019, 8:54 am -03
 *
 * @method LabelVariable findWithoutFail($id, $columns = ['*'])
 * @method LabelVariable find($id, $columns = ['*'])
 * @method LabelVariable first($columns = ['*'])
*/
class LabelVariableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description',
        'size',
        'size_start',
        'table',
        'field'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LabelVariable::class;
    }
}
