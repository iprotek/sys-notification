<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_notifications', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('group_id')->nullable();
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();

            $table->string('type');//updates or any
            $table->string('name'); //System Updates or any
            $table->string('summary');
            $table->string('description')->nullable();
            $table->string('ref_id')->nullable(); //commit_has or identity etc
            $table->string('status')->default('pending');
            $table->boolean('is_auto')->default(0);
            $table->bigInteger('requested_by')->nullable(); //0 mean auto
            $table->bigInteger('requested_pay_account_id')->nullable();
            $table->bigInteger('updated_by')->nullable(); //0 means auto
            $table->bigInteger('updated_pay_account_id')->nullable();
            $table->text('other_details')->nullable();
            $table->longText('error_message_result')->nullable(); 
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_models');
    }
}
