<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection(pWfmDBConnectionName())->create('task_flows', function ($table) {
            $table->increments('id');
            $table->integer('task_id',false)->unsigned()->nullable();
            $table->integer('task_action_id',false)->unsigned()->nullable();
            $table->integer('task_status_id',false)->unsigned()->nullable();
            $table->integer('status', false);
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('created_by', false)->unsigned()->nullable();
            $table->integer('last_modified_by', false)->unsigned()->nullable();
            $table->integer('deleted_by', false)->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on(pWfmDBName() . '.tasks')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('task_action_id')->references('id')->on(pWfmDBName() . '.task_actions')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('task_status_id')->references('id')->on(pWfmDBName() . '.task_statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on(pBusinessDBName() . '.organizations')->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on(pCommonDBName() . '.users')->onDelete('restrict');
            $table->foreign('last_modified_by')->references('id')->on(pCommonDBName() . '.users')->onDelete('restrict');
            $table->foreign('deleted_by')->references('id')->on(pCommonDBName() . '.users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection(pWfmDBConnectionName())->dropIfExists('task_flows');
    }
}
