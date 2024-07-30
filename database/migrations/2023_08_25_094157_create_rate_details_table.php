<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_details', function (Blueprint $table) {
            $table->id();
            $table->integer('rate_id')->nullable();
            $table->float('inpercentage')->nullable();
            $table->integer('inrupees')->nullable();
            $table->integer('min_basic')->nullable();
            $table->integer('max_basic')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('pay_type')->nullable();
            $table->string('cal_type')->nullable()->comment('v=variable,f=fixed');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('rate_details');
    }
}
