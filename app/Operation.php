<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $op_id
 * @property string $op_no
 * @property string $op_date
 * @property int $client_id
 * @property int $client_id2
 * @property int $employee_id
 * @property int $agent_id
 * @property int $plot_id
 * @property string $op_type
 * @property int $payment_method
 * @property float $op_price
 * @property float $op_advance
 * @property int $op_instalment_no
 * @property string $first_instalment
 * @property float $month_instalment
 * @property string $op_instalment_end
 * @property string $op_note
 * @property int $login_id
 * @property string $enter_time
 * @property int $edit_id
 * @property string $edit_time
 * @property int $canceled
 * @property int $cancel_type
 * @property int $cancellation_percentage
 * @property float $amount
 * @property int $register
 * @property int $reg_type
 * @property float $com_sale
 * @property float $agent_com
 * @property int $first
 * @property int $pay_type
 * @property float $cash_price
 * @property int $sellOrder
 * @property int $cuurency
 * @property int $rateID
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 */
class Operation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'operation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'op_id';

    /**
     * @var array
     */
    protected $fillable = ['op_no', 'op_date', 'client_id', 'client_id2', 'employee_id', 'agent_id', 'plot_id', 'op_type', 'payment_method', 'op_price', 'op_advance', 'op_instalment_no', 'first_instalment', 'month_instalment', 'op_instalment_end', 'op_note', 'login_id', 'enter_time', 'edit_id', 'edit_time', 'canceled', 'cancel_type', 'cancellation_percentage', 'amount', 'register', 'reg_type', 'com_sale', 'agent_com', 'first', 'pay_type', 'cash_price', 'sellOrder', 'cuurency', 'rateID', 'active', 'created_at', 'updated_at'];

}
