<?php

namespace App\Repositories;

use App\Models\Sector;
use InfyOm\Generator\Common\BaseRepository;

class SectorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'deposit_code',
        'code',
        'description',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sector::class;
    }
}
