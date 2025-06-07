<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\_CommonModel;

class SysNotifyScheduler extends _CommonModel
{
    use HasFactory, SoftDeletes;
    

    public $fillable = [
        "name",
        "type",
        "is_active"
    ];

    public $casts = [
        "is_active"=>"boolean"
    ];

    public $appends = [
        "sms_schedule_active_count",
        "sms_schedule_inactive_count"
    ];

    public function getSmsScheduleActiveCountAttribute(){
        return SysNotifyScheduleSmsTrigger::where(["is_active"=>1, "sys_notify_schedule_id"=>$this->id])->count();
    }

    public function getSmsScheduleInactiveCountAttribute(){
        return SysNotifyScheduleSmsTrigger::where(["sys_notify_schedule_id"=>$this->id])->where('is_active','!=',1)->count();
    }

    
}
