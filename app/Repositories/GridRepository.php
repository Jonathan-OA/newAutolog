<?php

namespace App\Repositories;

use App\Models\Grid;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GridRepository
 * @package App\Repositories
 * @version July 27, 2018, 11:34 am -03
 *
 * @method Grid findWithoutFail($id, $columns = ['*'])
 * @method Grid find($id, $columns = ['*'])
 * @method Grid first($columns = ['*'])
*/
class GridRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'module',
        'submodule',
        'columns'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Grid::class;
    }
}
