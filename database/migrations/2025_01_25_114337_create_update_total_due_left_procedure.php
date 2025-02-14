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
        // Create the stored procedure
        DB::unprepared('
            CREATE PROCEDURE UpdateTotalDueLeft()
            BEGIN
                UPDATE academy
                SET total_due_left = total_due_left + monthly_price;
            END
        ');

        // Create the event to call the procedure every 2 minutes
        DB::unprepared('
            CREATE EVENT UpdateTotalDueLeftEvent
            ON SCHEDULE EVERY 2 MINUTE
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