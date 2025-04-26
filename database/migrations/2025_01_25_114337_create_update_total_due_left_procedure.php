<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateUpdateTotalDueLeftProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop existing events
        DB::unprepared('DROP EVENT IF EXISTS UpdateTotalDueLeftEvent');

        // Drop existing procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateTotalDueLeft');

        // Create the stored procedure for both academy and parkings
        DB::unprepared('
            CREATE PROCEDURE UpdateTotalDueLeft()
            BEGIN
                -- Update academy table
                UPDATE academy
                SET total_due_left = total_due_left + monthly_price
                WHERE DATEDIFF(CURDATE(), joined_date) >= 30
                AND DATEDIFF(CURDATE(), joined_date) % 30 = 0
                AND del_flg = false;

                -- Update parkings table
                UPDATE parkings
                SET total_due = total_due + monthly_price
                WHERE DATEDIFF(CURDATE(), joined_date) >= 30
                AND DATEDIFF(CURDATE(), joined_date) % 30 = 0
                AND del_flg = false;
            END
        ');

        // Create the event to call the procedure daily
        DB::unprepared('
            CREATE EVENT UpdateTotalDueLeftEvent
            ON SCHEDULE EVERY 1 DAY
            STARTS CONCAT(CURDATE(), " 00:00:00")
            DO
                CALL UpdateTotalDueLeft();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the event
        DB::unprepared('DROP EVENT IF EXISTS UpdateTotalDueLeftEvent');

        // Drop the stored procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateTotalDueLeft');
    }
}