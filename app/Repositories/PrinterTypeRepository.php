<?php

namespace App\Repositories;

use App\Models\PrinterType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PrinterTypeRepository
 * @package App\Repositories
 * @version April 17, 2019, 2:58 pm -03
 *
 * @method PrinterType findWithoutFail($id, $columns = ['*'])
 * @method PrinterType find($id, $columns = ['*'])
 * @method PrinterType first($columns = ['*'])
*/
class PrinterTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PrinterType::class;
    }
}
