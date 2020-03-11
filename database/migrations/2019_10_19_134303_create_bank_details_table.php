<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('id')->references('id')->on('registerusers')->onDelete('cascade');

            $table->string('bank_Name')->nullable();
            $table->string('account_No')->nullable();
            $table->string('IFSC_Code')->nullable();
            $table->string('branch')->nullable();

            $table->enum('bank_details_updated', ['yes', 'no'])->default('no');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('bank_details');
    }

}
