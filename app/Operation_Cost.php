<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID
 * @property int $op_id
 * @property int $type
 * @property float $ammount
 * @property string $cost_date
 * @property string $recipt_no
 * @property int $lawyer
 * @property int $close
 * @property int $op_MG
 * @property int $acc
 * @property int $op_type
 */
class Operation_Cost extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'op_cost';

    /**
     * @var array
     */
    protected $fillable = ['ID', 'op_id', 'type', 'ammount', 'cost_date', 'recipt_no', 'lawyer', 'close', 'op_MG', 'acc', 'op_type'];

}
