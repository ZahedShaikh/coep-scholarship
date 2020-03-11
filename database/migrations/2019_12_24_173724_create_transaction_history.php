<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionHistory extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transaction_history', function (Blueprint $table) {

            $table->bigIncrements('transactionId');
            $table->string('fundingAgancy')->default('null');
            /* its a Student primary key but I dont want to enforce here. 
             * Since we'll have to insert it multiple time 
             */
            $table->string('id');

            $table->date('dateOfTransaction')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->year('year')->useCurrent();
            $table->float('amount')->nullable();

            $table->enum('amountReceivedForYear', ['1', '2', '3', '4', '5']);
            $table->enum('amountReceivedForSemester', ['1', '2', '3', '4', '5',
                '6', '7', '8', '9']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('transaction_history');
    }

}
