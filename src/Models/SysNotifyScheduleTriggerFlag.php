<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\_CommonModel;

class SysNotifyScheduleTriggerFlag extends _CommonModel
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "sys_notify_schedule_sms_triggers_id",
        "type",
        "date"
    ];
}
