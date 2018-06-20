<?php

namespace App\Repositories;

use App\Models\BlockedGroup;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BlockedGroupRepository
 * @package App\Repositories
 * @version June 20, 2018, 12:06 pm -03
 *
 * @method BlockedGroup findWithoutFail($id, $columns = ['*'])
 * @method BlockedGroup find($id, $columns = ['*'])
 * @method BlockedGroup first($columns = ['*'])
*/
class BlockedGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'deposit_code',
        'sector_code',
        'group_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BlockedGroup::class;
    }
}
