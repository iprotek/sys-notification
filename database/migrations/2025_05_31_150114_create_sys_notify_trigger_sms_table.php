<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysNotifyTriggerSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_notify_schedule_sms_triggers', function (Blueprint $table) {
            
            $table->iprotekDefaultColumns();

            //CUSTOMS
            $table->bigInteger('sms_client_api_request_link_id');
            $table->bigInteger('sys_notify_scheduler_id');
            $table->string('name');
            $table->longText('send_message');
            $table->string('notification_type');
            $table->string('to_type');
            $table->longText('selected_items');
            $table->longText('mobile_nos');
            $table->decimal('total_due', 15, 3)->default(0);
            $table->decimal('total_paid', 15, 3)->default(0);
            $table->boolean('is_active')->default(1);
            $table->integer('repeat_days_after')->default(0);
            $table->string('repeat_type');
            $table->text('repeat_info');
            $table->boolean('is_stop_when_fully_paid')->default(1);
            $table->string('status')->default('ongoing'); //ongoing, completed, failed
            $table->text('error_message')->nullable();
            $table->longText('other_settings')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_notify_trigger_sms');
    }
}
