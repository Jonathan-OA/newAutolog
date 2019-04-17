<?php

namespace App\Repositories;

use App\Models\LabelLayout;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LabelLayoutRepository
 * @package App\Repositories
 * @version April 17, 2019, 3:15 pm -03
 *
 * @method LabelLayout findWithoutFail($id, $columns = ['*'])
 * @method LabelLayout find($id, $columns = ['*'])
 * @method LabelLayout first($columns = ['*'])
*/
class LabelLayoutRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'code',
        'label_type_code',
        'printer_type_code',
        'description',
        'status',
        'commands',
        'width',
        'height',
        'across'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LabelLayout::class;
    }
}
