<?php

namespace iProtek\SysNotification\Helpers; 
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use iProtek\SysNotification\Models\SysNotifyScheduleSmsTrigger;

class ScheduleSmsHelper
{ 
    public static function schedule_trigger_send(SysNotifyScheduleSmsTrigger $schedule_trigger){

        //LOOP FOR SENDING
            //REPLACEMENT FOR VARIABLES
        
            //SENDS STARTS HERE

        
        //SAVE SEND $trigger

        return ["status"=>0, "message"=>"Sending completed"];


    }
}