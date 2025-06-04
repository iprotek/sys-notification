<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use iProtek\Core\Models\_CommonModel;

class SysNotification extends _CommonModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
         
        "type",
        "name",
        "summary",
        "description",
        "ref_id",
        "status",
        "is_auto",
        "requested_by",
        "requested_pay_account_id",
        "updated_by",
        "updated_pay_account_id",
        "other_details",
        "error_message_result"
        
    ]; 
}
