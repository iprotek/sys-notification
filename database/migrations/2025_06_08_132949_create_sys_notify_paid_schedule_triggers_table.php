<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysNotifyPaidScheduleTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_notify_paid_schedule_triggers', function (Blueprint $table) {
            
            $table->iprotekDefaultColumns();

            $table->bigInteger('sys_notify_schedule_sms_triggers_id');
            $table->decimal('due_amount', 10,3);
            $table->decimal('paid_amount',10,3);
            $table->decimal('balance_amount',10,3);
            $table->string("type");
            $table->text('message_template')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_notify_sms');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_notify_paid_schedule_triggers');
    }
}
