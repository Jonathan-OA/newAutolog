<?php

namespace App\Repositories;

use App\Models\DocumentStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DocumentStatusRepository
 * @package App\Repositories
 * @version July 11, 2018, 11:51 pm -03
 *
 * @method DocumentStatus findWithoutFail($id, $columns = ['*'])
 * @method DocumentStatus find($id, $columns = ['*'])
 * @method DocumentStatus first($columns = ['*'])
*/
class DocumentStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DocumentStatus::class;
    }
}
