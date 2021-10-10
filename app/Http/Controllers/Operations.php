<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Operation;
use App\Operation_Cost;
use App\Operation_Log;
use App\Payment;

class Operations extends Controller
{
    private $row = null;
    private $result = null;
    private $error = 0;
    private $code = null;
    public function modify_payment(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'op_id' => 'required|numeric',
            'type' => 'required|numeric',
            'new_installment_package' => 'numeric',
            'first_installment_date' => 'date',
            'last_installment_date' => 'date',
            'type' => 'string',


        ]);
        if ($validation->fails()) {
            $this->error = 0;
            $this->result = "Validation error";
        } else {
            $operation = Operation::find($request->op_id);
            $operation_log = new Operation_Log();
            $operation_log->oldValue = $operation->op_instalment_no;

            try {
                if ($request->type == 1) {
                    $operation->op_instalment_no = $request->new_installment_package;
                    $operation->first_instalment = $request->first_installment_date;
                    $operation->op_instalment_end = $request->last_installment_date;
                } elseif ($request->type == 2) {
                    $operation->payment_method = "1";
                    $operation->first_instalment = $request->first_installment_date;
                    $operation->op_instalment_end = $request->last_installment_date;
                } elseif ($request->type == 3) {
                    $operation->payment_method = "2";
                }
                $operation->save();
                if ($operation) {
                    $operation_log->op_id = $operation->op_id;
                    if ($request->type == 1) {
                        $operation_log->newValue = $request->new_installment_package;
                        $operation_log->feild_name = "installment package";
                    }
                    elseif ($request->type == 2) {
                        $operation_log->feild_name = "payment method";
                        $operation_log->oldValue = "2";
                        $operation_log->newValue = "1";
                    } elseif ($request->type == 3) {
                        $operation_log->feild_name = "payment method";
                        $operation_log->oldValue = "1";
                        $operation_log->newValue = "2";
                    } 

                    $operation_log->save();
                    $this->error = 1;
                    $this->result = "Success";
                    $this->code = 1;
                    $this->row = $operation->op_id;
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->error = 0;
                $this->result = $ex->errorInfo['2'];
                $this->code = $ex->getCode();
            }
        }

        $data = [
            "error" => $this->error,
            "code" =>  $this->code,
            "result" => $this->result,
            "data" => $this->row
        ];
        return response()->json($data)->getContent();
    }
    public function modify_owner(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'op_id' => 'required|numeric',
            'owner_name' => 'required|string',
            'fees' => 'required|numeric',
        ]);
        if ($validation->fails()) {
            $this->error = 0;
            $this->result = "Validation error";
        } else {

            try {
                $operation_log = new Operation_Log();
                $operation_cost = new Operation_Cost();
                $operation_log->op_id = $request->op_id;
                $operation_log->feild_name = "owner";
                $operation_log->newValue = $request->owner_name;
                /////////////////////
                $operation_cost->op_id = $request->op_id;
                $operation_cost->ammount = $request->fees;
                $operation_cost->type = "30";
                $operation_cost->lawyer = 0;
                $operation_cost->close = 0;
                $operation_cost->op_MG = 0;
                $operation_cost->acc = 0;
                $operation_cost->op_type = 0;

                $operation_log->save();
                $operation_cost->save();
                $this->error = 1;
                $this->result = "Success";
                $this->code = 1;
                $this->row = $operation_log->id;
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->error = 0;
                $this->result = $ex->errorInfo['2'];
                $this->code = $ex->getCode();
            }
        }
        $data = [
            "error" => $this->error,
            "code" =>  $this->code,
            "result" => $this->result,
            "data" => $this->row
        ];
        return response()->json($data)->getContent();
    }
    public function get_total_payments(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'op_id' => 'required|numeric',
        ]);
        if ($validation->fails()) {
            $this->error = 0;
            $this->result = "Validation error";
        } else {

            try {
        $payment = Payment::where('op_id', $request->op_id)->where('paid', "true")->sum('payment_ammount');
        $this->error = 1;
        $this->result = "Success";
        $this->code = 1;
        $this->row = $payment;
            }
        catch (\Illuminate\Database\QueryException $ex) {
            $this->error = 0;
            $this->result = $ex->errorInfo['2'];
            $this->code = $ex->getCode();
        }
    }
    $data = [
        "error" => $this->error,
        "code" =>  $this->code,
        "result" => $this->result,
        "data" => $this->row
    ];
    return response()->json($data)->getContent();
    }
    public function cancel_operation(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'cancel_type' => 'required|numeric',
            'op_id' => 'required|numeric',
            'rest_amount' => 'numeric',
            'talya_cancellation_percentage' => 'numeric',
            'returned_amount' => 'numeric',

        ]);
        if ($validation->fails()) {
            $this->error = 0;
            $this->result = "Validation error";
        } else {
            try {
                $operation = Operation::find($request->op_id);
                if ($request->cancel_type == 1) {
                    $operation->op_id = $request->op_id;
                    $operation->amount = $request->rest_amount;
                    $operation->cancellation_percentage = $request->talya_cancellation_percentage;
                    $operation->cancel_type = $request->cancel_type;
                } elseif ($request->cancel_type == 2) {
                    $operation->op_id = $request->op_id;
                    $operation->amount = $request->returned_amount;
                    $operation->cancellation_percentage = $request->talya_cancellation_percentage;
                    $operation->cancel_type = $request->cancel_type;
                } elseif ($request->cancel_type == 3) {
                    $operation->op_id = $request->op_id;
                    $operation->cancellation_percentage = $request->talya_cancellation_percentage;
                    $operation->cancel_type = $request->cancel_type;
                }
                $operation->save();
                $this->error = 1;
                $this->result = "Success";
                $this->code = 1;
                $this->row = $operation->op_id;
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->error = 0;
                $this->result = $ex->errorInfo['2'];
                $this->code = $ex->getCode();
            }
        }

        $data = [
            "error" => $this->error,
            "code" =>  $this->code,
            "result" => $this->result,
            "data" => $this->row
        ];
        return response()->json($data)->getContent();
    }
    public function insert_operation_cost(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'op_id' => 'required|numeric',
            'type' => 'required|numeric',
            'cost' => 'required|numeric',

        ]);
        if ($validation->fails()) {
            $this->error = 0;
            $this->result = "Validation error";
        } else {
            try {
                $operation_cost = new Operation_Cost();
                $operation_cost->op_id = $request->op_id;
                $operation_cost->type = $request->type;
                $operation_cost->ammount = $request->cost;
                $operation_cost->lawyer = 0;
                $operation_cost->close = 0;
                $operation_cost->op_MG = 0;
                $operation_cost->acc = 0;
                $operation_cost->op_type = 0;


                $operation_cost->save();
                $this->error = 1;
                $this->result = "Success";
                $this->code = 1;
                $this->row = $operation_cost->id;
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->error = 0;
                $this->result = $ex->errorInfo['2'];
                $this->code = $ex->getCode();
            }
        }

        $data = [
            "error" => $this->error,
            "code" =>  $this->code,
            "result" => $this->result,
            "data" => $this->row
        ];
        return response()->json($data)->getContent();
    }
    public function insert_payment(Request $request)
    {
            $validation = Validator::make($request->all(), [

                'client_id' => 'required|numeric',
                'plot_id' => 'required|numeric',
                'payment_method' => 'numeric',
                'paid_advance' => 'numeric',
                'purchased_package' => 'numeric',
                'client_paid_cash' => 'numeric',
                'first_installment_date' => 'date',
                'last_installment_date' => 'date',


            ]);
        
        if ($validation->fails()) {
            $this->error = 0;
            $this->result = "Validation error";
        } else {
            try {
                $operation = new Operation();
                if ($request->payment_method == 1) {
                    $operation->client_id = $request->client_id;
                    $operation->plot_id = $request->plot_id;
                    $operation->payment_method = $request->payment_method;
                    $operation->op_price = $request->client_paid_cash;
                } else {
                    $operation->client_id = $request->client_id;
                    $operation->plot_id = $request->plot_id;
                    $operation->payment_method = $request->payment_method;
                    $operation->op_advance = $request->paid_advance;
                    $operation->op_price = $request->client_paid_cash;
                    $operation->op_instalment_no = $request->purchased_package;
                    $operation->first_instalment = $request->first_installment_date;
                    $operation->op_instalment_end = $request->last_installment_date;
                }
                $operation->save();
                $this->error = 1;
                $this->result = "Success";
                $this->code = 1;
                $this->row = $operation->op_id;
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->error = 0;
                $this->result = $ex->errorInfo['2'];
                $this->code = $ex->getCode();
            }
        }

        $data = [
            "error" => $this->error,
            "code" =>  $this->code,
            "result" => $this->result,
            "data" => $this->row
        ];
        return response()->json($data)->getContent();
    }
}
