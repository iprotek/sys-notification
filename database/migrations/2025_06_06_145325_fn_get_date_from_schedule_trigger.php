<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FnGetDateFromScheduleTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET @@sql_mode='';");
        DB::unprepared("DROP FUNCTION IF EXISTS fnGetDateFromScheduleTrigger");
        DB::unprepared("
        CREATE FUNCTION `fnGetDateFromScheduleTrigger`(schedule_trigger_id BIGINT) RETURNS datetime
        BEGIN
            DECLARE _IsActive TINYINT(1);
            DECLARE _RepeatType VARCHAR(100);
            DECLARE _RepeatInfo TEXT;
            
            #REPEAT INFO SETTINGS
            DECLARE _MonthName VARCHAR(20);
            DECLARE _MonthDay INTEGER;
            DECLARE _WeekDay VARCHAR(20);
            DECLARE _DateTime DATETIME;
            DECLARE _Time TIME;
            DECLARE _CurWeekDay VARCHAR(20);
            DECLARE _WeekDifference INT;
            
            DECLARE _MonthNo INT;
            
            
            SELECT 
            is_active, repeat_type, repeat_info INTO _IsActive, _RepeatType, _RepeatInfo
            FROM 
            sys_notify_schedule_sms_triggers 
          WHERE id = schedule_trigger_id;

          #CHECK IF ACTIVE
          IF( _IsActive != 1) THEN
            RETURN NULL;
          END IF;
            #CHECK REPEAT INFO SETTINGS
            IF( _RepeatInfo = '' OR _RepeatInfo IS NULL) THEN
            RETURN NULL;
          END IF;    
            
            #SET REPEAT INFO FROM JSON
            SET _MonthName = fnJSON_VALUE(_RepeatInfo, '$.month_name');
            SET _MonthDay = fnJSON_VALUE(_RepeatInfo, '$.month_day');
            SET _WeekDay = fnJSON_VALUE(_RepeatInfo, '$.week_day');
          SET _DateTime = IFNULL(fnJSON_VALUE(_RepeatInfo, '$.datetime'), NOW());
            SET _Time = fnJSON_VALUE(_RepeatInfo, '$.time');
            SET _MonthNo = MONTH(STR_TO_DATE(_MonthName, '%b'));
            
            IF(_RepeatType = 'datetime')THEN
            
            RETURN _DateTime;
                
          ELSEIF(_RepeatType = 'yearly')THEN
            
            RETURN CONCAT( YEAR(NOW()),'-', _MonthNo, '-',_MonthDay,' ', _Time );
                
          ELSEIF(_RepeatType = 'daily')THEN
            
            RETURN CONCAT( DATE(NOW()),' ', _Time);
                
          ELSEIF(_RepeatType = 'monthly')THEN
            
            RETURN CONCAT( YEAR(NOW()),'-',MONTH(NOW()),'-',_MonthDay,' ', _Time);
                
          ELSEIF(_RepeatType = 'weekly')THEN
            
                SET _CurWeekDay = DATE_FORMAT(NOW(), '%a');
                
              SET _WeekDifference = (FIELD(_CurWeekDay, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun') -  FIELD(_WeekDay, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun') + 7) % 7;
                
                RETURN CONCAT( DATE( DATE_ADD( NOW(), INTERVAL _WeekDifference * -1 DAY)) ,' ', _Time);
                
            END IF;

          RETURN NULL;
        END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_trigger', function (Blueprint $table) {
            //
        });
    }
}
