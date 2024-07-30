<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_members')) {
            Schema::create('project_members', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('project_id');
                $table->integer('user_id');
                $table->string('role')->default('viewer');
                $table->integer('createdBy');
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
        Schema::dropIfExists('project_members');
    }
}
