<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('project_id');
                $table->integer('assignedTo');
                $table->string('task_name');
                $table->text('task_desc');
                $table->text('tags');
                $table->date('start_date')->nullable();
                $table->date('expected_end_date')->nullable();
                $table->integer('createdBy');
                $table->integer('updatedBy')->nullable();
                $table->string('priority');
                $table->string('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
