<?php

namespace iProtek\SysNotification\Helpers;

use iProtek\SysNotification\Models\SysNotification;

class SysNotificationHelper
{
    public static function checkUpdates(){
        $user_id = 0;
        $is_auto = 0;
        $requested_pay_account_id = 0;
        if(auth()->check()){
            $user_id = auth()->user()->id;
        }


        //git fetch
        $fetch_result = GitHelper::runGitCommand("git fetch");

        if($fetch_result === null){
            return ["status"=>0,"message"=>"Unable to get update."];
        }


        //git log ----
        $log_result = GitHelper::runGitCommand("git log --pretty=format:{\"commit_hash\":\"%h\",\"author_name\":\"%an\",\"author_email\":\"%ae\",\"date\":\"%ad\",\"commit_message\":\"%s\",\"description\":\"%b\"},  HEAD..FETCH_HEAD");
        if($log_result === null){
            return ["status"=>0,"message"=>"Failed to get logs."];
        }

    
        //save log to notifications---
        $log_arr = [];


        //$log_result - convert this to json and 
        if(strlen($log_result) > 1){
            $log_result = substr($log_result, 0, -1);
            $log_arr = json_decode($log_result, TRUE);
        }

        if(!is_array($log_arr)){
            ["status"=>0,"message"=>"Update logs error."];
        }

        if(count($log_arr)<= 0){
            ["status"=>1,"message"=>"You are updated."];
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
                "ref_id"=>$log['commit_has'],
                "status"=>"pending",
                "is_auto"=>$is_auto,
                "requested_by"=>$user_id,
                "requested_pay_account_id"=>$requested_pay_account_id
            ]);



        }
        $notifs = SysNotification::where("type",'git')->where("status","pending")->select('id','summary','description')->get();

        return  ["status"=>1,"message"=>"Gathers completed.", "updates"=>$notifs];
    }
}