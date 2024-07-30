<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInSubAdminRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_admin_registrations', function (Blueprint $table) {
            $table->date('verified_on')->nullable()->change();
            $table->date('sl_applied_on')->nullable()->change();
            $table->integer('agent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_admin_registrations', function (Blueprint $table) {
            //
        });
    }
}
