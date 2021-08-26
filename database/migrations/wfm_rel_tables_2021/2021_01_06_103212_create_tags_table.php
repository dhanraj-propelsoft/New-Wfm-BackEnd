<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(pWfmDBConnectionName())->create('tags', function($table){
            
            $table->increments('id');
            $table->string('name',20)->nullable();
            $table->integer('status', false);
            $table->integer('organization_id', false)->unsigned()->nullable();
            $table->integer('last_modified_by', false)->unsigned()->nullable();
            $table->integer('created_by', false)->unsigned()->nullable();
             $table->integer('deleted_by', false)->unsigned()->nullable();
            $table->timestamps();
            

            $table->foreign('organization_id')->references('id')->on(pBusinessDBName().'.organizations')->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::connection(pWfmDBConnectionName())->dropIfExists('tags');
    }
}
