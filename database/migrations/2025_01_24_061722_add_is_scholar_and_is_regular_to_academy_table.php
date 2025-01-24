<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsScholarAndIsRegularToAcademyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academy', function (Blueprint $table) {
            $table->boolean('is_scholar')->default(false); // Add isScholar column
            $table->boolean('is_regular')->default(false); // Add isRegular column
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
            $table->dropColumn(['is_scholar', 'is_regular']); // Drop the columns if rolling back
        });
    }
}