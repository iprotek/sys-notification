<?php

namespace iProtek\SysNotification\Http\Controllers;

use Illuminate\Http\Request;
use iProtek\SysNotification\Models\SysNotifyScheduler;
use iProtek\Core\Http\Controllers\_Common\_CommonController;
use iProtek\Core\Helpers\PayModelHelper;

class SysNotifyScheduleEmailTriggerController extends _CommonController
{ 
    public $guard = 'admin';
    
    public function index(Request $request){
        //$infos = $this->common_infos();
        return $this->view("iprotek_sys_notification::triggers.email");
    }

    /*
    public function list(Request $request){
        return $this->apiModelSelect(SysNotifyScheduler::class, $request, true, true);
    }

    public function add(Request $request){

        //
        $dataRequest = $this->validate($request, [
            "name"=>"required",
            "type"=>"required|in:email,sms,notification",
            "is_active"=>"required",
            "branch_id"=>"required"
        ])->validated();

        //CHECK IF EXISTS
        $exists = PayModelHelper::get(SysNotifyScheduler::class, $request)->where('name', $dataRequest['name'])->first();
        if($exists){
            return ["status"=>0, "message"=>"Name already exists"];
        }
        //
        $result = PayModelHelper::create(SysNotifyScheduler::class, $request, $dataRequest);
        return [
            "status"=>1, 
            "message"=>"Schedule Successfully Added.",
            "data_id"=>$result->id
        ];
    }

    public function get(Request $request){
        
        return PayModelHelper::get(SysNotifyScheduler::class, $request)->find($request->scheduler_id);
    
    }

    public function update(Request $request){

        $dataRequest = $this->validate($request, [
            "id"=>"required",
            "name"=>"required",
            //"type"=>"required|in:email,sms,notification",
            "is_active"=>"required",
            "branch_id"=>"required"
        ])->validated();

        $id = $dataRequest['id'];

        $getScheduler = PayModelHelper::get(SysNotifyScheduler::class, $request)->find($id);
        
        if(!$getScheduler){
            return ["status"=>0, "message"=>"Something goes wrong"];
        }

        //CHECK NAME IF ALREADY EXISTS
        $nameExists = PayModelHelper::get(SysNotifyScheduler::class, $request)->where('id','!=', $id)->where('name', $dataRequest['name'])->first();
        
        if($nameExists){
            return ["status"=>0, "message"=>"Name already taken."];
        }
        
        PayModelHelper::update($getScheduler, $request, $dataRequest);
        
        return [
            "status"=>1, 
            "message"=>"Schedule Successfully Updated.",
        ];

    }

    public function remove(Request $request){
        
        $item =  PayModelHelper::get(SysNotifyScheduler::class, $request)->find($request->scheduler_id);
        
        if(!$item){
            return ["status"=>0, "message"=>"Unable to remove."];
        }

        PayModelHelper::delete( $item , $request);

        return ["status"=>1, "message"=>"Unable to remove."];
    }
    */

}
