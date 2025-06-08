<?php

namespace iProtek\SysNotification\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\SysNotification\Models\SysNotifyPaidScheduleTrigger;
use iProtek\SysNotification\Models\SysNotifyScheduleSmsTrigger;
use iProtek\Core\Helpers\PayModelHelper;

class SysNotifyPaidScheduleTriggerController extends _CommonController
{
    //
    public $guard = 'admin';

    public function paid_list(Request $request){
        
        $data = $this->apiModelSelect(SysNotifyPaidScheduleTrigger::class, $request, true, false, " CONCAT(message_template, IFNULL(note,'')) like ?", "id DESC");
        $data["model"]->where('sys_notify_schedule_sms_triggers_id', $request->schedule_trigger_id);
        $data["model"]->where('type', $request->type);
        return $data["model"]->paginate(10);

    }

    public function add_pay(Request $request){


        //ADDING PAYMENTS BY OFFSET INSIDE THE TRIGGERS
        $schedule_trigger = SysNotifyScheduleSmsTrigger::find($request->sys_notify_schedule_sms_triggers_id);
        if(!$schedule_trigger){
            return ["status"=>0, "message"=>"Trigger not found!"];
        }

        //CHECK AND VALIDATIONS
            //FOR FULL PAYMENT
            if($schedule_trigger->total_paid >= $schedule_trigger->total_due){
                $schedule_trigger->status = "completed";
                $schedule_trigger->save();
                return ["status"=>0, "message"=>"Already paid all dues."];
            }

            //ADD PAYMENT DETAILS
            $balance_due = $schedule_trigger->total_due - $schedule_trigger->total_paid;

            $requestData = $this->validate($request, [
                "paid_amount"=>["required", function($attribute, $value, $fail)use($balance_due){
                    if(!is_numeric($value)){
                        $fail("Numeric value is required.");
                    }else if(  !($value * 1)){
                        $fail("Please fix paid amount value, should be more than zero.");
                    }
                    else if( $value > $balance_due){
                        $fail("Paid amount exceed to balance due! Please lower than balance due..");
                    }
                }],
                "sys_notify_schedule_sms_triggers_id"=>"required",
                "note"=>"nullable",
                "type"=>"required",
                "message_template"=>"nullable",
                "is_notify_sms"=>"required",
                "branch_id"=>"nullable"
            ])->validated();


            //SEND SMS IF ENABLED APPLICABLE
            if($request->is_notify_sms){
                if(!$request->message_template){
                    return ["status"=>0, "message"=>"Message Template is required if you allow to notify sms."];
                }
            }
        $result_id = 0;
        //ADDING PAYMENT DETAILS
        $requestData["due_amount"] = $balance_due;
        $requestData["balance_amount"] = $balance_due - ($requestData["paid_amount"] * 1);
        
        //CREATE
        $result = PayModelHelper::create(SysNotifyPaidScheduleTrigger::class, $request, $requestData);
        if($result){
            $result_id = $result->id;
        }

        //UPDATE TRIGGER ADD PAID TOTAL
        PayModelHelper::update( 
            $schedule_trigger, 
            $request, 
            [
                "total_paid"=>( $schedule_trigger->total_paid + $requestData["paid_amount"] )
            ] 
        );

        //IF BALANCE DUE EQUALS TO ZERO THEN MARK THE SCHEDULE TRIGGER COMPLETED.
        if($requestData["paid_amount"] ==  $balance_due){
            $schedule_trigger->status = "completed";
            $schedule_trigger->save();
        }

    
        //SMS SUBMISSIN HERE...
        if($request->is_notify_sms){

        }
        
        if($requestData["paid_amount"] ==  $balance_due){
            return ["status"=>1, "message"=>"Payment has completed.", "data_id"=> $result_id];
        }


        return ["status"=>1, "message"=>"Paid Success!", "data_id"=> $result_id];
    }


}
