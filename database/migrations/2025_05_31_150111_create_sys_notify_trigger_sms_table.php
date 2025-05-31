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
            $table->bigInteger('sms_notify_schedule_id');
            $table->string('name');
            $table->string('notification_type');
            $table->string('to_type');
            $table->longText('selected_items');
            $table->longText('mobile_nos');
            $table->decimal('total_due', 15, 3)->default(0);
            $table->decimal('total_paid', 15, 3)->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_stop_when_fully_paid')->default(1);
            $table->text('error_message')->nullable();

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
