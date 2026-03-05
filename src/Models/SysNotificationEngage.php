<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use iProtek\Core\Models\_CommonModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysNotificationEngage extends _CommonModel
{
    //
    use HasFactory, SoftDeletes;
    public $fillable = [

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",
        "branch_id",
        
        "notice_count"
        
    ];

}
