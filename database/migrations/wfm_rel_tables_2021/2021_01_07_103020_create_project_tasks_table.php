<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
        Schema::connection(pWfmDBConnectionName())->create('project_tasks', function($table){
            
        $table->increments('id');
        $table->integer('task_id' ,false)->unsigned()->nullable();
        $table->integer('project_id',false)->unsigned()->nullable();
        $table->integer('status', false);
        $table->integer('created_by', false)->unsigned()->nullable();
        $table->integer('last_modified_by', false)->unsigned()->nullable();
        $table->integer('deleted_by', false)->unsigned()->nullable();
        $table->timestamps();

        $table->foreign('task_id')->references('id')->on(pWfmDBName().'.tasks')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('project_id')->references('id')->on(pWfmDBName().'.projects')->onUpdate('cascade')->onDelete('cascade');


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

        Schema::connection(pWfmDBConnectionName())->dropIfExists('project_tasks');
    }
}
