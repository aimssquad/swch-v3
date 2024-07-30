<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubAdminRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_admin_registrations', function (Blueprint $table) {
            $table->id();
            $table->text('com_name')->nullable();
            $table->text('f_name')->nullable();
            $table->text('l_name')->nullable();
            $table->text('email')->nullable();
            $table->text('p_no')->nullable();
            $table->text('pass')->nullable();
            $table->string('reg')->nullable()->index();
            $table->text('fax')->nullable();
            $table->text('address')->nullable();
            $table->text('website')->nullable();
            $table->text('pan')->nullable();
            $table->text('logo')->nullable();
            $table->text('desig')->nullable();
            $table->text('com_reg')->nullable();
            $table->text('com_type')->nullable();
            $table->text('com_year')->nullable();
            $table->text('com_nat')->nullable();
            $table->text('no_em')->nullable();
            $table->text('work_per')->nullable();
            $table->text('no_dire')->nullable();
            $table->text('country')->nullable();
            $table->text('currency')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('acconut_name')->nullable();
            $table->text('sort_code')->nullable();
            $table->text('others_type')->nullable();
            $table->text('nature_type')->nullable();
            $table->text('no_em_work')->nullable();
            $table->text('con_num')->nullable();
            $table->text('authemail')->nullable();
            $table->text('trad_name')->nullable();
            $table->text('address2')->nullable();
            $table->text('road')->nullable();
            $table->text('city')->nullable();
            $table->text('zip')->nullable();
            $table->text('status')->nullable();
            $table->text('verify')->nullable();
            $table->text('employee_link')->nullable();
            $table->text('licence')->nullable();
            $table->text('proof')->nullable();
            $table->text('sun_status')->nullable();
            $table->text('sun_time')->nullable();
            $table->text('mon_status')->nullable();
            $table->text('mon_time')->nullable();
            $table->text('tue_status')->nullable();
            $table->text('tue_time')->nullable();
            $table->text('wed_status')->nullable();
            $table->text('wed_time')->nullable();
            $table->text('thu_status')->nullable();
            $table->text('thu_time')->nullable();
            $table->text('fri_status')->nullable();
            $table->text('fri_time')->nullable();
            $table->text('sat_status')->nullable();
            $table->text('sat_time')->nullable();
            $table->text('sun_close')->nullable();
            $table->text('mon_close')->nullable();
            $table->text('tue_close')->nullable();
            $table->text('wed_close')->nullable();
            $table->text('thu_close')->nullable();
            $table->text('fri_close')->nullable();
            $table->text('sat_close')->nullable();
            $table->text('trad_status')->nullable();
            $table->text('trad_other')->nullable();
            $table->text('penlty_status')->nullable();
            $table->text('penlty_other')->nullable();
            $table->text('bank_status')->nullable();
            $table->text('bank_other')->nullable();
            $table->text('key_f_name')->nullable();
            $table->text('key_f_lname')->nullable();
            $table->text('key_designation')->nullable();
            $table->text('key_phone')->nullable();
            $table->text('key_email')->nullable();
            $table->text('key_proof')->nullable();
            $table->text('key_bank_status')->nullable();
            $table->text('key_bank_other')->nullable();
            $table->text('level_f_name')->nullable();
            $table->text('level_f_lname')->nullable();
            $table->text('level_designation')->nullable();
            $table->text('level_phone')->nullable();
            $table->text('level_email')->nullable();
            $table->text('level_proof')->nullable();
            $table->text('level_bank_status')->nullable();
            $table->text('level_bank_other')->nullable();
            $table->text('key_person')->nullable();
            $table->text('level_person')->nullable();
            $table->text('organ_email')->nullable();
            $table->text('land')->nullable();
            $table->text('license_type')->nullable();
            $table->text('inactive_remarks')->nullable();
            $table->text('verified_on')->nullable();
            $table->text('sl_applied_on')->nullable();
            $table->text('agent_id')->nullable();
            $table->text('country_code')->nullable();
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
        Schema::dropIfExists('sub_admin_registrations');
    }
}
