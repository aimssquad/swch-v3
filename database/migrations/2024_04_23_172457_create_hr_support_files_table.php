<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrSupportFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_support_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('title');
            $table->text('small_description');
            $table->text('description');
            $table->string('pdf')->nullable();
            $table->string('doc')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('hr_support_file_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_support_files');
    }
}
