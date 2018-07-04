<?php

namespace App\Repositories;

use App\Models\LiberationRule;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LiberationRuleRepository
 * @package App\Repositories
 * @version July 4, 2018, 1:43 pm -03
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
