<?php

namespace App\Repositories;

use App\Models\DocumentType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DocumentTypeRepository
 * @package App\Repositories
 * @version March 1, 2018, 8:10 pm UTC
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
        'moviment_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DocumentType::class;
    }
}
