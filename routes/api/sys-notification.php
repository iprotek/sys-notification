<?php


use Illuminate\Support\Facades\Route;  
use iProtek\SysNotification\Http\Controllers\SysNotifySchedulerController; 
use iProtek\SysNotification\Http\Controllers\SysNotifyScheduleSmsTriggerController; 
use iProtek\Xrac\Http\Controllers\XbranchController;
use Illuminate\Http\Request;
use iProtek\SysNotification\Helpers\SysNotificationHelper;
//use iProtek\Core\Http\Controllers\Manage\CmsController;
//use App\Http\Controllers\Manage\BillingSharedAccountDefaultBranchController;

 
Route::prefix('/sys-notification')->name('.sys-notification')->group(function(){
    
    //Route::post('/save', [ CmsController::class ,'save_cms'])->name('.save'); 
    //Route::post('/get-content', [ CmsController::class ,'get_cms'])->name('.get'); 
    //Route::get('list', [XbranchController::class, 'branch_list'])->name('.list');
    
    Route::get('to-type-list', function(Request $request){
        return SysNotificationHelper::toTypeList();
    })->name('.type-list');
    


    Route::prefix('schedulers')->name('.schedulers')->group(function(){
        
        Route::get('list', [SysNotifySchedulerController::class, 'list'])->name('.list');

        Route::get('list/{scheduler_id}', [SysNotifySchedulerController::class, 'get'])->name('.get');

        Route::post('add', [SysNotifySchedulerController::class, 'add'])->name('.add');
        
        Route::put('update', [SysNotifySchedulerController::class, 'update'])->name('.update');
        
        Route::delete('list/{scheduler_id}', [SysNotifySchedulerController::class, 'remove'])->name('.remove');


        Route::prefix('triggers')->name('.triggers')->group(function(){

            Route::prefix('sms')->name('.sms')->group(function(){

                Route::get('list', [SysNotifyScheduleSmsTriggerController::class, 'list'])->name('.list');

                Route::post('add', [SysNotifyScheduleSmsTriggerController::class, 'add'])->name('.add');
                
                Route::put('update', [SysNotifyScheduleSmsTriggerController::class, 'update'])->name('.update');

                Route::get('get/{schedule_trigger_id}', [SysNotifyScheduleSmsTriggerController::class, 'get'])->name('.get');

            });

        });
    
    });

});