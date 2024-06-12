<?php

namespace iProtek\SysNotification\Helpers;

use iProtek\SysNotification\Models\SysNotification;

class SysNotificationHelper
{
    public static function checkUpdates(){

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
        //$log_result - convert this to json and




        return  ["status"=>1,"message"=>"Gather completed.", "data"=>$log_result];
    }
}