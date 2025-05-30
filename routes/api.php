<?php
use Illuminate\Support\Facades\Route; 

Route::prefix('api')->middleware(['api'])->group(function(){

    Route::prefix('group/{group_id}')->middleware(['pay.api'])->name('api')->group(function(){
        
        //FILE UPLOADS
        include(__DIR__.'/api/sys-notification.php');

    });

});