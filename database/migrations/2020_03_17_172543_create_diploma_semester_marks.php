<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiplomaSemesterMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diploma_semester_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('id')->references('id')->on('registerusers')->onDelete('cascade');

            $table->string('semester1')->nullable();
            $table->string('semester2')->nullable();
            $table->string('semester3')->nullable();
            $table->string('semester4')->nullable();
            $table->string('semester5')->nullable();
            $table->string('semester6')->nullable();

            // To be updated dynamically
            $table->string('CGPA')->nullable();
            $table->enum('semester_marks_updated', ['yes', 'no'])->default('no');
            
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
        Schema::dropIfExists('diploma_semester_marks');
    }
}
