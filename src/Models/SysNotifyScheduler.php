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
}
