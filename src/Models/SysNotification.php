<?php

namespace iProtek\SysNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by",
         
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
