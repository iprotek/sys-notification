<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysNotifySchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_notify_schedulers', function (Blueprint $table) {
            
            $table->iprotekDefaultColumns();
            
            //Customs
            $table->string('name');
            $table->string('type');
            $table->boolean('is_active')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_notify_schedulers');
    }
}
