<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use iProtek\Core\Models\_CommonModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysNotifyScheduleSmsTrigger extends _CommonModel
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "sms_client_api_request_link_id",
        "sys_notify_schedule_id",
        "name",
        "send_message",
        "notification_type",
        "to_type",
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
}
