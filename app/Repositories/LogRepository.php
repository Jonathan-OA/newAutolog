<?php

namespace App\Repositories;

use App\Models\Log;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LogRepository
 * @package App\Repositories
 * @version July 16, 2018, 12:05 am -03
 *
 * @method Log findWithoutFail($id, $columns = ['*'])
 * @method Log find($id, $columns = ['*'])
 * @method Log first($columns = ['*'])
*/
class LogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'description',
        'user_id',
        'operation_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Log::class;
    }
}
