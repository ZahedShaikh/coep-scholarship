<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScholarshipRejectedList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarship_rejected_list', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->string('middleName')->nullable();
            $table->string('surName');
            $table->enum('category', ['OPEN', 'OBC', 'EWS', 'SC', 'ST', 'SBC', 'VJ', 'NT-1', 'NT-2', 'NT-3', 'ECBC', 'OTHER']);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->year('yearOfAdmission');
            $table->string('contact');
            $table->string('college');
            $table->string('email');
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
        Schema::dropIfExists('scholarship_rejected_list');
    }
}
