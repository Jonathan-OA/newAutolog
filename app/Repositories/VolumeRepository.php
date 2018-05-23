<?php

namespace App\Repositories;

use App\Models\Volume;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VolumeRepository
 * @package App\Repositories
 * @version March 28, 2018, 4:04 pm -03
 *
 * @method Volume findWithoutFail($id, $columns = ['*'])
 * @method Volume find($id, $columns = ['*'])
 * @method Volume first($columns = ['*'])
*/
class VolumeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'barcode',
        'document_id',
        'date',
        'status',
        'label_id',
        'location_code',
        'height',
        'stacking',
        'packing_type_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Volume::class;
    }
}
