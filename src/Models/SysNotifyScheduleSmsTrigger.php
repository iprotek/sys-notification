<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use iProtek\Core\Models\_CommonModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\SmsSender\Models\SmsClientApiRequestLink;

class SysNotifyScheduleSmsTrigger extends _CommonModel
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "sms_client_api_request_link_id",
        "sys_notify_scheduler_id",
        "name",
        "send_message",
        "notification_type",
        "to_type", //on settings
        "selected_items",
        "mobile_nos",
        "total_due",
        "total_paid",
        "is_active",
        "repeat_days_after",
        "repeat_type",
        "repeat_info",
        "is_stop_when_fully_paid",
        "status", //ongoing, completed, failed
        "error_message",
        "other_settings"
    ];

    public $casts = [
        "selected_items"=>"json",
        "mobile_nos"=>"json",
        "repeat_info"=>"json",
        "other_settings"=>"json",
        "is_active"=>"boolean",
        "is_stop_when_fully_paid"=>"boolean"
    ];

    public function sms_client_api_request_link(){
        return $this->belongsTo(SmsClientApiRequestLink::class, 'sms_client_api_request_link_id');
    }

    public function sys_notify_scheduler(){
        return $this->belongsTo(SysNotifyScheduler::class, 'sys_notify_scheduler_id');
    }
}
