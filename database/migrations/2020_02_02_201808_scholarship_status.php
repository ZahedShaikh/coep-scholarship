<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScholarshipStatus extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('scholarship_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('id')->references('id')->on('registerusers')->onDelete('cascade');

            $table->string('scholarshipName')->default('null');
            
            //$table->enum('issuing_authority_status', ['approved', 'pending'])->default('pending');
            //$table->enum('account_status', ['approved', 'pending'])->default('pending');
            $table->enum('in_process_with', ['issuer', 'accountant', 'done', 'pending'])->default('issuer');
            
            $table->date('lastest_approved_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->integer('prev_amount_received_in_semester')->default(-1);
            $table->integer('now_receiving_amount_for_semester')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('scholarship_status');
    }

}
