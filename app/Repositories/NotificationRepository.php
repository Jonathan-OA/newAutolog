<?php

namespace App\Repositories;

use App\Models\Notification;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NotificationRepository
 * @package App\Repositories
 * @version July 10, 2019, 5:34 pm -03
 *
 * @method Notification findWithoutFail($id, $columns = ['*'])
 * @method Notification find($id, $columns = ['*'])
 * @method Notification first($columns = ['*'])
*/
class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'message',
        'visualized'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notification::class;
    }
}
