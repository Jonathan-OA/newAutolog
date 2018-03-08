<?php

namespace App\Repositories;

use App\Models\LabelType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LabelTypeRepository
 * @package App\Repositories
 * @version March 8, 2018, 3:15 pm -03
 *
 * @method LabelType findWithoutFail($id, $columns = ['*'])
 * @method LabelType find($id, $columns = ['*'])
 * @method LabelType first($columns = ['*'])
*/
class LabelTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'code',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LabelType::class;
    }
}
