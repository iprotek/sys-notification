<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sys_notification_account_targets', function (Blueprint $table) {
            $table->iprotekDefaultColumns();
            $table->bigInteger('sys_notification_id');
            $table->bigInteger('target_account_id');
            $table->boolean('is_seen')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_notification_account_targets');
    }
};
