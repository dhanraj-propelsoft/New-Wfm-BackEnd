<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection(pWfmDBConnectionName())->create('task_attachments', function ($table) {
            $table->increments('id');
            $table->integer('task_id', false)->unsigned()->nullable();
            $table->string('upload_file')->nullable(20);
            $table->string('file_original_name')->nullable(20);
            $table->integer('status', false);

            $table->integer('created_by', false)->unsigned()->nullable();
            $table->integer('last_modified_by', false)->unsigned()->nullable();
            $table->integer('deleted_by', false)->unsigned()->nullable();
            $table->timestamps();


            $table->foreign('task_id')->references('id')->on(pWfmDBName() . '.tasks')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::connection(pWfmDBConnectionName())->dropIfExists('task_attachments');
    }
}
