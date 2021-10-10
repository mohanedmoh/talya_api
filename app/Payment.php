<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $payment_id
 * @property int $payment_no
 * @property string $payment_date
 * @property int $op_id
 * @property float $payment_ammount
 * @property int $chaque_no
 * @property string $chaque_bank
 * @property string $paid
 * @property string $recipt
 * @property string $recipt_date
 * @property string $notification
 * @property string $reason
 * @property int $Canceled
 * @property int $op_type
 * @property int $rateID
 */
class Payment extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'payment_id';

    /**
     * @var array
     */
    protected $fillable = ['payment_no', 'payment_date', 'op_id', 'payment_ammount', 'chaque_no', 'chaque_bank', 'paid', 'recipt', 'recipt_date', 'notification', 'reason', 'Canceled', 'op_type', 'rateID'];

}
