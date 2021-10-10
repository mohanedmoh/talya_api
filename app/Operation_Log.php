<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $op_id
 * @property string $date
 * @property int $user_id
 * @property string $feild_name
 * @property string $oldValue
 * @property string $newValue
 */
class Operation_Log extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'op_log';

    /**
     * @var array
     */
    protected $fillable = ['op_id', 'date', 'user_id', 'feild_name', 'oldValue', 'newValue'];

}
