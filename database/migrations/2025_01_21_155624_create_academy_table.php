<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademyTable extends Migration
{
    public function up()
    {
        Schema::create('academy', function (Blueprint $table) {
            $table->id(); // id
            $table->string('student_name'); // student_name
            $table->decimal('monthly_price', 8, 2); // monthly_price
            $table->integer('age'); // age
            $table->string('phone_no'); // phone no
            $table->string('email')->unique(); // email
            $table->decimal('total_due_left', 8, 2); // total_due_left
            $table->date('joined_date'); // joined date
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('academy');
    }
}
