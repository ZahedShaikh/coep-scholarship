<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegisterUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('registerusers', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('middleName')->nullable();
            $table->string('surName');
            $table->enum('category', ['OPEN', 'OBC', 'EWS', 'SC', 'ST', 'SBC', 'VJ', 'NT-1', 'NT-2', 'NT-3', 'ECBC', 'OTHER']);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('yearOfAdmission');
            $table->string('contact');
            $table->string('college');
            
            // Somtimes students get Enrollment no late so not forcing.
            $table->string('collegeEnrollmentNo')->nullable()->unique();
            $table->enum('user_profile_updated', ['yes', 'no'])->default('no');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('registerusers');
    }

}
