<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_code');
            $table->string('emid');
            $table->string('emp_reporting_auth');
            $table->date('apprisal_period_start');
            $table->date('apprisal_period_end');
            $table->string('createdBy')->nullable();
            $table->string('updatedBy')->nullable();
            $table->enum('status', ['pending', 'submitted', 'recheck', 'completed']);
            $table->text('performance_comments')->nullable();
            $table->text('performance_feedback')->nullable();
            $table->integer('rating');
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
        Schema::dropIfExists('performace');
    }
}
