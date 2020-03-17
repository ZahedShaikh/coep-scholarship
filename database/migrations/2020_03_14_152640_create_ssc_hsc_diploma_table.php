<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSscHscDiplomaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssc_hsc_diploma', function (Blueprint $table) {
            $table->id();
            $table->foreign('id')->references('id')->on('registerusers')->onDelete('cascade');
            
            $table->float('ssc')->nullable();
            $table->year('sscYear')->nullable();
             
            $table->float('hsc')->nullable();
            $table->year('hscYear')->nullable();
            
            $table->float('diploma')->nullable();
            $table->year('diplomaYear')->nullable();
            
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
        Schema::dropIfExists('ssc_hsc_diploma');
    }
}
