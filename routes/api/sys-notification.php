<?php


use Illuminate\Support\Facades\Route;  
use iProtek\SysNotification\Http\Controllers\SysNotifySchedulerController; 
use iProtek\SysNotification\Http\Controllers\SysNotifyScheduleSmsTriggerController; 
use iProtek\SysNotification\Http\Controllers\SysNotifyPaidScheduleTriggerController;
use iProtek\Xrac\Http\Controllers\XbranchController;
use Illuminate\Http\Request;
use iProtek\SysNotification\Helpers\SysNotificationHelper;
use iProtek\SysNotification\Http\Controllers\SysNotificationController;
//use iProtek\Core\Http\Controllers\Manage\CmsController;
//use App\Http\Controllers\Manage\BillingSharedAccountDefaultBranchController;

 
Route::prefix('/sys-notification')->name('.sys-notification')->group(function(){
    
    //Route::post('/save', [ CmsController::class ,'save_cms'])->name('.save'); 
    //Route::post('/get-content', [ CmsController::class ,'get_cms'])->name('.get'); 
    //Route::get('list', [XbranchController::class, 'branch_list'])->name('.list');
    
    Route::get('to-type-list', [ 
        "uses"=>function(Request $request){
            return SysNotificationHelper::toTypeList();
        },
        "description"=>"System Notification types",
        "is_visible"=>true,
        "is_allow"=>true
    ])->name('.type-list');
    


    Route::prefix('schedulers')->name('.schedulers')->group(function(){
        
        Route::get('list', [
            "uses"=>[SysNotifySchedulerController::class, 'list'],
            "description"=>"Notification scheduler lists",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.list');

        Route::get('list/{scheduler_id}', [
            "uses"=>[SysNotifySchedulerController::class, 'get'],
            "description"=>"Notification scheduler",
            "is_visible"=>false,
            "is_allow"=>false
        ])->name('.get');

        Route::post('add', [
            "uses"=>[SysNotifySchedulerController::class, 'add'],
            "description"=>"Add notification scheduler",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.add');
        
        Route::put('update', [ 
            "uses"=>[SysNotifySchedulerController::class, 'update'],
            "description"=>"Update notification scheduler",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.update');
        
        Route::delete('list/{scheduler_id}', [
            "uses"=>[SysNotifySchedulerController::class, 'remove'],
            "description"=>"Update branches from centralize controls",
            "is_visible"=>true,
            "is_allow"=>false
        ])->name('.remove');


        Route::prefix('triggers')->name('.triggers')->group(function(){

            Route::prefix('sms')->name('.sms')->group(function(){

                Route::get('list', [ 
                    "uses"=>[SysNotifyScheduleSmsTriggerController::class, 'list'],
                    "description"=>"List of sms trigger to a schedule",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.list');

                Route::post('add', [
                    "uses"=>[SysNotifyScheduleSmsTriggerController::class, 'add'],
                    "description"=>"Add sms trigger on a schedule",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.add');
                
                Route::put('update', [
                    "uses"=>[SysNotifyScheduleSmsTriggerController::class, 'update'],
                    "description"=>"Update sms trigger on a schedule",
                    "is_visible"=>true,
                    "is_allow"=>false
                ])->name('.update');

                Route::prefix('get/{schedule_trigger_id}')->name('.get')->group(function(){

                    Route::get('/', [
                        "uses"=>[SysNotifyScheduleSmsTriggerController::class, 'get'],
                        "description"=>"Get all trigger results on a specific trigger command in a schedule",
                        "is_visible"=>true,
                        "is_allow"=>false
                    ])->name('.get');
                    
                    Route::get('trigger-list', [
                        "uses"=>[SysNotifyScheduleSmsTriggerController::class, 'trigger_list'],
                        "description"=>"List of trigger in a schedule",
                        "is_visible"=>true,
                        "is_allow"=>false
                    ])->name('.trigger-list');

                    Route::prefix('paid')->name('.paid')->group(function(){
                        
                        //LIST
                        Route::get('list',[ 
                            "uses"=>[SysNotifyPaidScheduleTriggerController::class, 'paid_list'],
                            "description"=>"Get paid list of specific trigger on a schedule",
                            "is_visible"=>true,
                            "is_allow"=>false
                        ])->name('.list');
                        //ADD
                        Route::post('add-pay',[
                            "uses"=>[SysNotifyPaidScheduleTriggerController::class, 'add_pay'],
                            "description"=>"Add pay of specific trigger on a schedule",
                            "is_visible"=>false,
                            "is_allow"=>false
                        ])->name('.add-pay');
                        //ADD NOTE
                        Route::post('resend-sms-payment', [
                            "uses"=>[SysNotifyPaidScheduleTriggerController::class, 'resend_sms_payment'],
                            "description"=>"Resend for payment info",
                            "is_visible"=>true,
                            "is_allow"=>false
                        ])->name('.resend-sms-payment');

                    });

                });
                //Route::get('get/{schedule_trigger_id}', [SysNotifyScheduleSmsTriggerController::class, 'get'])->name('.get');


            });

        });
    
    });

    Route::get('clear', [
        "uses"=>[SysNotificationController::class, 'clear_notification'],
        "description"=>"Clear up notification every click",
        "is_visible"=>false,
        "is_allow"=>true
    ])->name('.clear');

});