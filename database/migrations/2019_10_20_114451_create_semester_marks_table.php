<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemesterMarksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('semester_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('id')->references('id')->on('registerusers')->onDelete('cascade');

            $table->string('semester1')->nullable();
            $table->string('semester2')->nullable();
            $table->string('semester3')->nullable();
            $table->string('semester4')->nullable();
            $table->string('semester5')->nullable();
            $table->string('semester6')->nullable();
            $table->string('semester7')->nullable();
            $table->string('semester8')->nullable();

            // To be updated dynamically
            $table->string('CGPA')->nullable();
            $table->enum('semester_marks_updated', ['yes', 'no'])->default('no');

            // Add validity for 7-8 months
            $table->date('marks_validity')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('semester_marks');
    }

}
