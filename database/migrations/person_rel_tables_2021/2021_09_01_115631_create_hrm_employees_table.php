<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned()->nullable(false);
            $table->string('employee_code', '50')->nullable(true);
            $table->string('emergency_contact_no', '50')->nullable(true);
            $table->integer('organization_id')->unsigned()->nullable(false);

            $table->integer('created_by', false)->unsigned()->nullable();
            $table->integer('last_modified_by', false)->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('organization_id')->references('id')->on(pBusinessDBName() . '.organizations')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('last_modified_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_employees');
    }
}
