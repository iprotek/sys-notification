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
        "sms_notify_schedule_id",
        "name",
        "notification_type",
        "to_type",
        "selected_items",
        "mobile_nos",
        "total_due",
        "total_paid",
        "is_active",
        "is_stop_when_fully_paid",
        "error_message"
    ];
}
