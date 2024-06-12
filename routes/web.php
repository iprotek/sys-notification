<?php

use Illuminate\Support\Facades\Route; 

//Route::prefix('sms-sender')->name('sms-sender')->group(function(){
  //  Route::get('/', [SmsController::class, 'index'])->name('.index');
//});

Route::prefix('manage/sys-notification')->name('manage.sys-notification')->middleware(['auth'])->group(function(){
    Route::get('/test', [SmsController::class, 'index'])->name('.test');
});