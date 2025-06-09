<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use iProtek\Core\Models\_CommonModel;

class SysNotifyPaidScheduleTrigger extends _CommonModel
{
    use HasFactory;
    
    public $fillable = [
        "sys_notify_schedule_sms_triggers_id",
        "due_amount",
        "paid_amount",
        "balance_amount",
        "type",
        "message_template",
        "is_notify_sms",
        "note"
    ];

    protected $casts = [
        "is_notify_sms"=>"boolean",
        "created_at"=>"datetime:Y-m-d h:i A",
        "updated_at"=>"datetime:Y-m-d h:i A",
    ];


}
