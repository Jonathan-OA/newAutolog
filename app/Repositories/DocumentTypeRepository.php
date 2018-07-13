<?php

namespace App\Repositories;

use App\Models\DocumentType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DocumentTypeRepository
 * @package App\Repositories
 * @version July 13, 2018, 1:58 pm -03
 *
 * @method DocumentType findWithoutFail($id, $columns = ['*'])
 * @method DocumentType find($id, $columns = ['*'])
 * @method DocumentType first($columns = ['*'])
*/
class DocumentTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description',
        'moviment_code',
        'lib_automatic',
        'lib_location',
        'num_automatic',
        'print_labels',
        'partial_lib',
        'lib_deposits'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DocumentType::class;
    }
}
