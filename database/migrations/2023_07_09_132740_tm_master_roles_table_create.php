<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TmMasterRolesTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tm_master_roles')) {
            Schema::create('tm_master_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('status');
                $table->integer('project_id');
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
        Schema::dropIfExists('tm_master_roles');
    }
}
