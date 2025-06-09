<?php

namespace iProtek\SysNotification\Console\Commands;

use Illuminate\Console\Command;
use iProtek\SysNotification\Models\SysNotifyScheduleSmsTrigger;
use Illuminate\Support\Facades\Log;
use iProtek\SysNotification\Helpers\ScheduleSmsHelper;
use iProtek\SysNotification\Models\SysNotifyScheduleTriggerFlag;

class SmsScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iprotek:sys-notification-sms-schedule {--test=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the PHP Value';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 
        $repeat_count = config('iprotek_sys_notification.interval_sms_send_count') ?? 1;
        if(!is_numeric($repeat_count)){
            $repeat_count = 1;
        }
        $is_test = false;
        $test_value = "";
        if(   $this->option('test') != "0"){
            $is_test = true;
            $test_value = $this->option('test');
        }

        if($is_test){            
            
            echo "TEST MODE:";

            $gg = SysNotifyScheduleSmsTrigger::where(['is_active'=> 1, "status"=>"test" ])
            ->with(['sms_client_api_request_link'])
            ->whereHas('sys_notify_scheduler', function($q){
                $q->where('is_active', 1);
            })
            ->whereHas('sms_client_api_request_link', function($q){
                $q->where('is_active', 1);
            })
            ->first();

            if($gg){
                ScheduleSmsHelper::schedule_trigger_send($gg);
            }else{
                echo "Nothing to be tested. Please set status: `test`";
            }

        }
        else{
            echo "PROD MODE($repeat_count):..\r\n";
            //REPEAT THIS x50
            
            for($counter = 0; $counter < $repeat_count; $counter++){
                $gg = SysNotifyScheduleSmsTrigger::where(['is_active'=> 1, "status"=>"ongoing" ])
                ->with(['sms_client_api_request_link'])
                ->whereHas('sys_notify_scheduler', function($q){
                    $q->where('is_active', 1);
                })
                ->whereHas('sms_client_api_request_link', function($q){
                    $q->where('is_active', 1);
                })
                ->whereRaw(" id NOT IN( select sys_notify_schedule_sms_triggers_id FROM sys_notify_schedule_trigger_flags WHERE date = DATE(NOW()) AND `type` = 'sms' )")
                //FOR SCHEDULE
                ->whereRaw(" TIME(fnGetDateTimeFromScheduleTrigger(id)) < TIME(NOW()) AND  ( DATE(NOW()) BETWEEN DATE(fnGetDateTimeFromScheduleTrigger(id)) AND DATE_ADD(fnGetDateTimeFromScheduleTrigger(id), INTERVAL repeat_days_after DAY) ) ")
                ->first();
                if($gg){
                    
                    //TODO:: ADD TRIGGERED FLAG RECORD THIS DAY TO AVOID REPEAT
                    SysNotifyScheduleTriggerFlag::create([
                        "group_id"=>$gg->group_id,
                        "branch_id"=>$gg->branch_id,
                        "sys_notify_schedule_sms_triggers_id"=>$gg->id,
                        "type"=>"sms",
                        "date"=>\Carbon\Carbon::now()->format('Y-m-d')
                    ]);

                    $result = ScheduleSmsHelper::schedule_trigger_send($gg);
                    
                    echo json_encode($result)."\r\n";

                }else{
                    if($counter == 0){
                        echo "NOTHING TRIGGERED";
                    }
                    else{
                        echo "Done!";
                    }
                    break;
                    //BREAK IF LOOP
                }
            }
        }


    }
}
