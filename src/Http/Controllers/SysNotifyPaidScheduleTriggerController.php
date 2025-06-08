<?php

namespace iProtek\SysNotification\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\SysNotification\Models\SysNotifyPaidScheduleTrigger;

class SysNotifyPaidScheduleTriggerController extends _CommonController
{
    //
    public $guard = 'admin';

    public function paid_list(Request $request){
        
        $data = $this->apiModelSelect(SysNotifyPaidScheduleTrigger::class, $request, true, false, " CONCAT(message_template, IFNULL(note,'')) like ?", "id DESC");
        $data["model"]->where('type', $request->type);
        return $data["model"]->paginate(10);

    }


}
