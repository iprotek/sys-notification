<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysNotifyScheduleTriggerFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_notify_schedule_trigger_flags', function (Blueprint $table) {
            
            $table->iprotekDefaultColumns();

            $table->bigInteger('sys_notify_schedule_sms_triggers_id');
            $table->string('type');
            $table->date('date');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_notify_schedule_trigger_flags');
    }
}
