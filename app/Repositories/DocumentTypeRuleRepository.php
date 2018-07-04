<?php

namespace App\Repositories;

use App\Models\DocumentTypeRule;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DocumentTypeRuleRepository
 * @package App\Repositories
 * @version July 4, 2018, 1:45 pm -03
 *
 * @method DocumentTypeRule findWithoutFail($id, $columns = ['*'])
 * @method DocumentTypeRule find($id, $columns = ['*'])
 * @method DocumentTypeRule first($columns = ['*'])
*/
class DocumentTypeRuleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'document_type_code',
        'liberation_rule_code',
        'order'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DocumentTypeRule::class;
    }
}
