<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentHistoryToAcademyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academy', function (Blueprint $table) {
            $table->json('payment_history')->nullable(); // Add the payment_history column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academy', function (Blueprint $table) {
            $table->dropColumn('payment_history'); // Drop the payment_history column
        });
    }
}