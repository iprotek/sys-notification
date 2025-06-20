<?php

namespace iProtek\SysNotification\Helpers;

use iProtek\SysNotification\Models\SysNotification;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SysNotificationHelper
{
    public static function SystemUpdatesSummary(){


        //Get System Updates
        $all_summary = [];
        $total = 0;

        //GIT
        $system_updates = \DB::select("SELECT count(*) as count, `type`, min(created_at) as created_at FROM sys_notifications WHERE status='pending' group by `type` "); // SysNotification::where(["status"=>"pending", "type"=>"git"])->selectRaw( " count(*) as count, min(created_at) as created_at " )->get()[0];
        foreach($system_updates as $update){
            $name = $update->type;
            if($update->type == 'git'){
                $name = "System Updates";
            }
            else if($update->type == 'report'){
                $name = "Reports";
            }
            else if($update->type == 'message'){
                $name = "New Messages";
            }
            else if($update->type == 'friend-request'){
                $name = "Friend Request";
            }
            else{
                $name = strtoupper($name);
            }
           
            $all_summary[]=[
                "type"=>"git",
                "name"=>$name,
                "count"=>$update->count,
                "diff"=>static::diffForHumans($update->created_at)
            ];
            $total = $total + $update->count;
        }

        return ["summary"=>$all_summary,"total"=>$total];
    }

    public static function diffForHumans($datetimeString){
        
        // Example datetime string 
        if(!$datetimeString)
            return "";

        // Parse the datetime string
        $parsedDate = Carbon::parse($datetimeString);

        return $parsedDate->diffForHumans();

        // Current datetime
        $now = Carbon::now();

        // Get the human-readable difference
        $difference = $now->diffForHumans($parsedDate);

        return $difference;
    }


    public static function checkSystemUpdates($is_auto = 0){
        $user_id = 0; 
        $requested_pay_account_id = 0;
        if(auth()->check()){
            $user_id = auth()->user()->id;
        }


        //git fetch
        $fetch_result = GitHelper::runGitCommand("git fetch", true);

        if($fetch_result === null){
            return ["status"=>0,"message"=>"Unable to get update."];
        }


        //git log ----
        $git_log = "git log --pretty=format:{\"commit_hash\":\"%h\",\"author_name\":\"%an\",\"author_email\":\"%ae\",\"date\":\"%ad\",\"commit_message\":\"%s\",\"description\":\"%b\"},  HEAD..FETCH_HEAD";
        $log_result = GitHelper::runGitCommand($git_log);

        if($log_result === null){
            return ["status"=>0,"message"=>"Failed to get logs."];
        }
        //Log::error( "Data:". $log_result);
    
        //save log to notifications---
        $log_arr = [];


        //$log_result - convert this to json and 
        if(strlen($log_result) > 1){
            //$log_result = mb_convert_encoding($log_result, 'UTF-8', 'auto');
            if(substr($log_result,0, 1) == "\""){
                $log_result = substr($log_result, 1);
            }

            $log_result = substr($log_result, 0, -1);

            $log_result = preg_replace('/\r\n|\r|\n/', '', $log_result);

            $log_arr = json_decode( "[".$log_result."]", TRUE);
        }

        if(!is_array($log_arr)){
            ["status"=>0,"message"=>"Update logs error."];
        }

        try{
            //Log::error($log_result);
            //Log::error($log_arr);
            //Log::error($git_log);

            if(count($log_arr)<= 0){
                ["status"=>1,"message"=>"You are updated."];
            }
        }catch(\Exception $ex){

            //Just git pull here...


            Log::error($ex);
            return;
        }


        //Saving updates to system notifications
        foreach($log_arr as $log){

            //Check if exists
            $exists = SysNotification::where("name","System Update")->where( "type","git")->where("ref_id",$log['commit_hash'])->first();
            if($exists){
                continue;
            }

            //ADD
            SysNotification::create([
                "name"=>"System Update", 
                "type"=>"git",
                "summary"=>$log['commit_message']?:"",
                "description"=>$log['description']?:"",
                "ref_id"=>$log['commit_hash'],
                "status"=>"pending",
                "is_auto"=>$is_auto,
                "requested_by"=>$user_id,
                "requested_pay_account_id"=>$requested_pay_account_id
            ]);



        }
        $notifs = SysNotification::where("type",'git')->where("status","pending")->select('id','summary','description')->get();
        if( count($notifs) == 0 )
        return  ["status"=>1,"message"=>"You are currently updated."];

        return  ["status"=>1,"message"=>"Gathers completed.", "updates"=>$notifs];
    }

    public static function applySystemUpdates($is_auto = 0, $force = false){
        $user_id = 0; 
        $requested_pay_account_id = 0;
        if(auth()->check()){
            $user_id = auth()->user()->id;
        }

        //
        if($force){
            $result = static::checkUpdates();
            if($result['status'] == 0){
                return $result;
            }
            if($result['status'] == 1 && ( !$result['updates']  || count($result['updates']) == 0)){
                return ["status"=>1, "message"=>"Currently updated."];
            }
        }

        $has_migrations = false;
        $update_results = [];
        $notifs = SysNotification::where("type",'git')->whereRaw(" status<>'completed' ")->get();
        if(count($notifs)<=0){
            return ["status"=>1, "message"=>"Nothing to update."];
        }

        $composer_updates = [];
        //COMPOSER UPDATE
        foreach($notifs as $notif){
            
            if($notif->summary == "*UPDATES*"){

                $descs = explode("\\n", $notif->description);
                foreach($descs as $str){ 
                    $str = trim($str);
                    if($str){
                        if(!in_array($str, $composer_updates)){
                            $composer_updates[] = $str;
                        }
                    }
                }
            }
            if($notif->summary == "*MIGRATES*"){
                $has_migrations = true;
            }
        }

        foreach($composer_updates as $comp){
            if( GitHelper::runGitCommand($comp, false, true) === null){
                $update_results[] = "Failed: ".$comp;
            }
        }



        //MIGRATION
        if($has_migrations == true){
            if( GitHelper::runGitCommand("php artisan migrate") === null ){
                $update_results[] = "Migration successful.";
            }else{
                $update_results[] = "Failed: Migration successful.";
            }
        }


        $check_out_result = GitHelper::runGitCommand("git checkout main");
        if($check_out_result === null){
            return ["status"=>0, "message"=>"Failed to render updates."];
        }

        $merge_result = GitHelper::runGitCommand("git merge");
        if($merge_result === null){
            return ["status"=>0, "message"=>"Update Failed."];
        }
        foreach($notifs as $notif){
            $notif->updated_by = $user_id;
            $notif->is_auto = $is_auto;
            $notif->updated_pay_account_id = $requested_pay_account_id;
            $notif->status = "completed";
            $notif->save();
        }
        return ["status"=>1, "message"=>"Successfully Updated.", "updates"=>$update_results ];
    }

    public static function toTypeList(){
        
        $to_type = config('iprotek_sys_notification.to_type_list');

        $items = array_filter( explode(',', $to_type), function($item){
            return trim($item);
        });
        $list = [];
        foreach($items as $item){
            $list[] = trim($item);
        }
        return $list;
    }

}