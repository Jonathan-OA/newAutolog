<?php

namespace App\Repositories;

use App\Models\Deposit;
use InfyOm\Generator\Common\BaseRepository;

class DepositRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'department_code',
        'code',
        'deposit_type_code',
        'description',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Deposit::class;
    }
}
