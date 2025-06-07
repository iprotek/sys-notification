<?php

namespace iProtek\SysNotification\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\SysNotification\Models\SysNotifyScheduleSmsTrigger;
use iProtek\SysNotification\Models\SysNotifyScheduler;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Core\Helpers\PayModelHelper;
use iProtek\SysNotification\Helpers\SysNotificationHelper;
use iProtek\SmsSender\Models\SmsClientApiRequestLink;

class SysNotifyScheduleSmsTriggerController extends _CommonController
{ 
    public $guard = 'admin';
    
    public function index(Request $request, SysNotifyScheduler $scheduler){
        
        return $this->view("iprotek_sys_notification::triggers.sms", ["scheduler_id"=>$scheduler->id], true);
        
    }

    public function list(Request $request){
        
        $data = $this->apiModelSelect(SysNotifyScheduleSmsTrigger::class, $request, true, false);

        $data["model"]->where('sys_notify_schedule_id', $request->scheduler_id);

        $data["model"]->select('*', \DB::raw("fnGetDateTimeFromScheduleTrigger(id) as datetime_schedule") );
        return $data["model"]->paginate(10);
        return $data["model"];
    
    }

    
    public function add(Request $request){
        
        //month_name
        //month_day
        //week_day
        //datetime
        //time

        $toTypes = SysNotificationHelper::toTypeList();
        if(count($toTypes)<= 0){
            return ["status"=>0, "message"=>"Something goes wrong with target \"To Types\"."];
        }
        //REPEAT TYPE CHECKING
        //YEARLY =
        if( $request->repeat_type == "yearly" ){
            
            $this->validate($request, [
                "month_name"=>"required|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec",
                "month_day"=>"required|integer|min:1|max:25",
                "time"=>"required|date_format:H:i"
            ]);
            
        }
        //MONTHLY =
        else if( $request->repeat_type == "monthly"){

            $this->validate($request, [
                "month_day"=>"required|integer|min:1|max:25",
                "time"=>"required|date_format:H:i"
            ]);

        }
        //WEEKLY =
        else if( $request->repeat_type == "weekly" ){

            $this->validate($request, [
                "week_day"=>"required|in:Sun,Mon,Tue,Wed,Thu,Fri,Sat",
                "time"=>"required|date_format:H:i"
            ]);
            //return["status"=>0,"message"=>"Weekly Succeed"];
        }
        //DAILY =
        else if( $request->repeat_type == "daily"){

            $this->validate($request, [
                "time"=>"required|date_format:H:i"
            ]);
            
        }
        //ONSCHED = datetime
        else if( $request->repeat_type == "datetime"){
            $this->validate($request, [
                "datetime"=>"required|date_format:Y-m-d\TH:i"
            ]);
            /*
            $this->validate($request, [
                "datetime"=>"required|date|after:now"
            ]);
            */

        }

        //FOR NOTIFICATION
        if($request->notification_type == 'payment'){
            
            $this->validate($request, [
                "total_due"=>"required|numeric|min:10.00"
            ]);

        }


        $dataRequest = $this->validate($request, [
            "name"=>"required",
            "branch_id"=>"required",
            "sms_client_api_request_link_id"=>"required|integer",
            "sys_notify_schedule_id"=>"required",
            "send_message"=>"required",
            "notification_type"=>"required",
            "to_type"=>"required|in:".implode(",",$toTypes),
            "selected_items"=>"required|array|min:1",
            "mobile_nos"=>"required|array|min:1",
            "total_due"=>"required",
            "total_paid"=>"required",
            "is_active"=>"required",
            "repeat_days_after"=>"required|integer|min:0|max:5",
            "repeat_type"=>"required|string|in:yearly,monthly,weekly,daily,datetime",
            "repeat_info"=>"required|array",
            "other_settings"=>"nullable"
        ])->validated();


        //CHECK SMS SENDER IF STILL ACTIVE
        //sms_client_api_request_link_id
        $sms_api_link = SmsClientApiRequestLink::where('is_active', 1)->find($request->sms_client_api_request_link_id);
        if(!$sms_api_link){
            return ["status"=>0, "message"=>"Sms api request link not found."];
        }

        //CHECK SELECTED ITEMS

        //CHECK MOBILE NOS 
        
        //CHECK IF EXISTS
        $exists = PayModelHelper::get(SysNotifyScheduleSmsTrigger::class, $request)->where('name', $dataRequest['name'])->where('branch_id', $dataRequest['branch_id'] )->first();
        if($exists){
            return ["status"=>0, "message"=>"Name already exists"];
        }
        //
        $result = PayModelHelper::create(SysNotifyScheduleSmsTrigger::class, $request, $dataRequest);
        return [
            "status"=>1, 
            "message"=>"Schedule Successfully Added.",
            "data_id"=>$result->id
        ];
    }

    public function get(Request $request){
        
        return PayModelHelper::get(SysNotifyScheduleSmsTrigger::class, $request)->with(['sms_client_api_request_link'])->where('branch_id', $request->branch_id)->find($request->schedule_trigger_id);
    
    }

    public function update(Request $request){

        //month_name
        //month_day
        //week_day
        //datetime
        //time

        $toTypes = SysNotificationHelper::toTypeList();
        if(count($toTypes)<= 0){
            return ["status"=>0, "message"=>"Something goes wrong with target \"To Types\"."];
        }
        //REPEAT TYPE CHECKING
        //YEARLY =
        if( $request->repeat_type == "yearly" ){
            
            $this->validate($request, [
                "month_name"=>"required|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec",
                "month_day"=>"required|integer|min:1|max:25",
                "time"=>"required|date_format:H:i"
            ]);
            
        }
        //MONTHLY =
        else if( $request->repeat_type == "monthly"){

            $this->validate($request, [
                "month_day"=>"required|integer|min:1|max:25",
                "time"=>"required|date_format:H:i"
            ]);

        }
        //WEEKLY =
        else if( $request->repeat_type == "weekly" ){

            $this->validate($request, [
                "week_day"=>"required|in:Sun,Mon,Tue,Wed,Thu,Fri,Sat",
                "time"=>"required|date_format:H:i"
            ]);
            //return["status"=>0,"message"=>"Weekly Succeed"];
        }
        //DAILY =
        else if( $request->repeat_type == "daily"){

            $this->validate($request, [
                "time"=>"required|date_format:H:i"
            ]);
            
        }
        //ONSCHED = datetime
        else if( $request->repeat_type == "datetime"){
            $this->validate($request, [
                "datetime"=>"required|date_format:Y-m-d\TH:i"
            ]);
            /*
            $this->validate($request, [
                "datetime"=>"required|date|after:now"
            ]);
            */

        }

        //FOR NOTIFICATION
        if($request->notification_type == 'payment'){
            
            $this->validate($request, [
                "total_due"=>"required|numeric|min:10.00"
            ]);

        }

        //CHECK SMS SENDER IF STILL ACTIVE
        //sms_client_api_request_link_id
        $sms_api_link = SmsClientApiRequestLink::where('is_active', 1)->find($request->sms_client_api_request_link_id);
        if(!$sms_api_link){
            return ["status"=>0, "message"=>"Sms api request link not found."];
        }

        $dataRequest = $this->validate($request, [
            "id"=>"required|integer",
            "name"=>"required",
            "branch_id"=>"required",
            "sms_client_api_request_link_id"=>"required|integer",
            "sys_notify_schedule_id"=>"required",
            "send_message"=>"required",
            "notification_type"=>"required",
            "to_type"=>"required|in:".implode(",",$toTypes),
            "selected_items"=>"required|array|min:1",
            "mobile_nos"=>"required|array|min:1",
            "total_due"=>"required",
            "total_paid"=>"required",
            "is_active"=>"required",
            "repeat_days_after"=>"required|integer|min:0|max:5",
            "repeat_type"=>"required|string|in:yearly,monthly,weekly,daily,datetime",
            "repeat_info"=>"required|array",
            "other_settings"=>"nullable"
        ])->validated();

        $id = $dataRequest['id'];

        $getSchedule = PayModelHelper::get(SysNotifyScheduleSmsTrigger::class, $request)->find($id);
        
        if(!$getSchedule){
            return ["status"=>0, "message"=>"Something goes wrong"];
        }

        //CHECK NAME IF ALREADY EXISTS
        $nameExists = PayModelHelper::get(SysNotifyScheduleSmsTrigger::class, $request)->where('id','!=', $id)->where('name', $dataRequest['name'])->first();
        
        if($nameExists){
            return ["status"=>0, "message"=>"Name already taken."];
        }
        
        PayModelHelper::update($getSchedule, $request, $dataRequest);
        
        return [
            "status"=>1, 
            "message"=>"Schedule Successfully Updated.",
        ];

    }

    /*
    public function remove(Request $request){
        
        $item =  PayModelHelper::get(SysNotifyScheduler::class, $request)->find($request->scheduler_id);
        
        if(!$item){
            return ["status"=>0, "message"=>"Unable to remove."];
        }

        PayModelHelper::delete( $item , $request);

        return ["status"=>1, "message"=>"Unable to remove."];
    }
    */

}
