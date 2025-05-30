<?php


use Illuminate\Support\Facades\Route;  
use iProtek\SysNotification\Http\Controllers\SysNotifySchedulerController; 
use iProtek\Xrac\Http\Controllers\XbranchController;
use Illuminate\Http\Request;
//use iProtek\Core\Http\Controllers\Manage\CmsController;
//use App\Http\Controllers\Manage\BillingSharedAccountDefaultBranchController;

 
Route::prefix('/sys-notification')->name('.sys-notification')->group(function(){
    
    //Route::post('/save', [ CmsController::class ,'save_cms'])->name('.save'); 
    //Route::post('/get-content', [ CmsController::class ,'get_cms'])->name('.get'); 
    //Route::get('list', [XbranchController::class, 'branch_list'])->name('.list');
    Route::prefix('schedules')->name('.schedules')->group(function(){
        Route::get('list', [SysNotifySchedulerController::class, 'list'])->name('.list');
    });

});