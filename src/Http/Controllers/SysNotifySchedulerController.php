<?php

namespace iProtek\SysNotification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; 
use App\Models\UserAdminPayAccount;
use iProtek\SysNotification\Models\SysNotification;
use iProtek\SysNotification\Models\SysNotifyScheduler;
use Illuminate\Support\Facades\Artisan;
use iProtek\Core\Http\Controllers\_Common\_CommonController;

class SysNotifySchedulerController extends _CommonController
{ 
    public $guard = 'admin';
    
    public function index(Request $request){
        //$infos = $this->common_infos();
        return $this->view("iprotek_sys_notification::scheduler");
    }

    public function list(Request $request){
        return $this->apiModelSelect(SysNotifyScheduler::class, $request, true, true);
    }

    

}
