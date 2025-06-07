<?php

namespace iProtek\SysNotification\Helpers; 
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use iProtek\SysNotification\Models\SysNotifyScheduleSmsTrigger;
use iProtek\SmsSender\Helpers\AutoSelectSmsHelper;

class ScheduleSmsHelper
{ 

    public static function compose_message($name_info, SysNotifyScheduleSmsTrigger $schedule_trigger){
        //[person_name]
        //[total_due]
        //[total_paid]
        //[total_balance]
        $person_name = $name_info->name;
        $total_due = $schedule_trigger->total_due ?? 0;
        $total_paid = $schedule_trigger->total_paid ?? 0;
        $total_balance = $total_due - $total_paid;

        $message =  $schedule_trigger->send_message;
        $message = str_replace('[person_name]', $person_name, $message);
        $message = str_replace('[total_due]', number_format($total_due, 2, '.', ','), $message);
        $message = str_replace('[total_paid]', number_format($total_paid, 2, '.', ','), $message);
        $message = str_replace('[total_balance]', number_format($total_balance, 2, '.', ','), $message);

        return $message;

    }

    public static function schedule_trigger_send(SysNotifyScheduleSmsTrigger $schedule_trigger){
        //echo json_encode( $schedule_trigger );

        if(!$schedule_trigger->sms_client_api_request_link){
            $schedule_trigger = SysNotifyScheduleSmsTrigger::with(['sms_client_api_request_link'])->find($schedule_trigger->id);

            if(!$schedule_trigger->sms_client_api_request_link){
                return ["status"=>0, "message"=>"SMS sender is not available"];
            }
        }

        //echo  json_encode($schedule_trigger->selected_items);
        //LOOP FOR SENDING
        foreach($schedule_trigger->selected_items as $item){
            //REPLACEMENT FOR VARIABLES
            $item = json_decode(json_encode($item));

            $message = static::compose_message($item, $schedule_trigger);
            //echo $message;
            $res = AutoSelectSmsHelper::send($item->mobile_no, $message, $schedule_trigger->sms_client_api_request_link, "sms-schedule-notification-".$schedule_trigger->id );
            echo json_encode($res);
            //SENDS STARTS HERE

        }
        //SAVE SEND $trigger
        

        return ["status"=>0, "message"=>"Sending completed"];


    }




}