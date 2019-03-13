<?php

namespace App\Repositories;

use App\Models\LiberationRule;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LiberationRuleRepository
 * @package App\Repositories
 * @version March 11, 2019, 1:54 pm -03
 *
 * @method LiberationRule findWithoutFail($id, $columns = ['*'])
 * @method LiberationRule find($id, $columns = ['*'])
 * @method LiberationRule first($columns = ['*'])
*/
class LiberationRuleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'module_name',
        'description',
        'enabled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LiberationRule::class;
    }
}
