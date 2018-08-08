<?php

namespace App\Repositories;

use App\Models\Support;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SupportRepository
 * @package App\Repositories
 * @version August 8, 2018, 11:43 am -03
 *
 * @method Support findWithoutFail($id, $columns = ['*'])
 * @method Support find($id, $columns = ['*'])
 * @method Support first($columns = ['*'])
*/
class SupportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'user_code',
        'url',
        'message',
        'users_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Support::class;
    }
}
