<?php

namespace App\Repositories;

use App\Models\Graph;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GraphRepository
 * @package App\Repositories
 * @version July 27, 2018, 10:17 am -03
 *
 * @method Graph findWithoutFail($id, $columns = ['*'])
 * @method Graph find($id, $columns = ['*'])
 * @method Graph first($columns = ['*'])
*/
class GraphRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'code',
        'title',
        'type',
        'color',
        'enabled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Graph::class;
    }
}
