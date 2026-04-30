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
    
    Route::get('to-type-list', function(Request $request){
            return SysNotificationHelper::toTypeList();
        })
        ->defaults("_description", "System Notification types")
        ->defaults("_is_visible", true)
        ->defaults("_is_allow", true)
        ->name('.type-list');
    


    Route::prefix('schedulers')->name('.schedulers')->group(function(){
        
        Route::get('list', [ SysNotifySchedulerController::class, 'list'])
            ->defaults("_description","Notification scheduler lists")
            ->defaults("_is_visible",true)
            ->defaults("_is_allow",false)
            ->name('.list');

        Route::get('list/{scheduler_id}', [SysNotifySchedulerController::class, 'get'])
            ->defaults("_description","Notification scheduler")
            ->defaults("_is_visible",true)
            ->defaults("_is_allow",false)
            ->name('.get');

        Route::post('add', [ SysNotifySchedulerController::class, 'add'])
            ->defaults("_description","Add notification scheduler")
            ->defaults("_is_visible",true)
            ->defaults("_is_allow",false)
            ->name('.add');
        
        Route::put('update', [ SysNotifySchedulerController::class, 'update'])
            ->defaults("_description","Update notification scheduler")
            ->defaults("_is_visible",true)
            ->defaults("_is_allow",false)
            ->name('.update');
        
        Route::delete('list/{scheduler_id}', [ SysNotifySchedulerController::class, 'remove'])
            ->defaults("_description","Update branches from centralize controls")
            ->defaults("_is_visible",true)
            ->defaults("_is_allow",false)
            ->name('.remove');


        Route::prefix('triggers')->name('.triggers')->group(function(){

            Route::prefix('sms')->name('.sms')->group(function(){

                Route::get('list', [ SysNotifyScheduleSmsTriggerController::class, 'list'])
                    ->defaults("_description","List of sms trigger to a schedule")
                    ->defaults("_is_visible",true)
                    ->defaults("_is_allow",false)
                    ->name('.list');

                Route::post('add', [SysNotifyScheduleSmsTriggerController::class, 'add'])
                    ->defaults("_description","Add sms trigger on a schedule") 
                    ->defaults("_is_visible",true)
                    ->defaults("_is_allow",false)
                    ->name('.add');
                
                Route::put('update',  [SysNotifyScheduleSmsTriggerController::class, 'update'])
                    ->defaults("_description","Update sms trigger on a schedule")
                    ->defaults("_is_visible",true)
                    ->defaults("_is_allow",false)
                    ->name('.update');

                Route::prefix('get/{schedule_trigger_id}')->name('.get')->group(function(){

                    Route::get('/', [SysNotifyScheduleSmsTriggerController::class, 'get'])
                        ->defaults("_description","Get a specific sms trigger on a schedule")
                        ->defaults("_is_visible",true)
                        ->defaults("_is_allow",false)
                        ->name('.get');
                    
                    Route::get('trigger-list',  [SysNotifyScheduleSmsTriggerController::class, 'trigger_list'])
                        ->defaults("_description","List of trigger in a schedule")
                        ->defaults("_is_visible",true)
                        ->defaults("_is_allow",false)
                        ->name('.trigger-list');

                    Route::prefix('paid')->name('.paid')->group(function(){
                        
                        //LIST
                        Route::get('list',[SysNotifyPaidScheduleTriggerController::class, 'paid_list'])
                            ->defaults("_description","Get paid list of specific trigger on a schedule")
                            ->defaults("_is_visible",true)
                            ->defaults("_is_allow",false)
                            ->name('.list');
                        //ADD
                        Route::post('add-pay', [SysNotifyPaidScheduleTriggerController::class, 'add_pay'])
                            ->defaults("_description", "Add pay of specific trigger on a schedule" )
                            ->defaults("_is_visible",false)
                            ->defaults("_is_allow",false)
                            ->name('.add-pay');
                        //ADD NOTE
                        Route::post('resend-sms-payment',  [SysNotifyPaidScheduleTriggerController::class, 'resend_sms_payment'])
                            ->defaults("_description", "Resend for payment info")
                            ->defaults("_is_visible",true)
                            ->defaults("_is_allow",false)
                            ->name('.resend-sms-payment');

                    });

                });
                //Route::get('get/{schedule_trigger_id}', [SysNotifyScheduleSmsTriggerController::class, 'get'])->name('.get');


            });

        });
    
    });

    Route::get('clear',  [SysNotificationController::class, 'clear_notification'])
        ->defaults("_description","Clear up notification every click")
        ->defaults("_is_visible",false)
        ->defaults("_is_allow",true)
        ->name('.clear');

});