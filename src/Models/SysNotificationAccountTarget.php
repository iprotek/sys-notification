<?php

namespace App\Models;

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use iProtek\Core\Models\_CommonModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysNotificationAccountTarget extends _CommonModel
{
    //
    use HasFactory, SoftDeletes;
    public $fillable = [

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",
        "branch_id",

        "sys_notification_id",
        "target_account_id",
        "is_seen"
    ];
}
