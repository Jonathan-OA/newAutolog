<?php

namespace App\Repositories;

use App\Models\Graph;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GraphRepository
 * @package App\Repositories
 * @version July 25, 2018, 5:47 pm -03
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
        'description',
        'type',
        'qry'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Graph::class;
    }
}
