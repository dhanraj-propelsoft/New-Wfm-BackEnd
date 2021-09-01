<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailnotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailnotifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_id', '12');
            $table->string('to_id', '12');
            $table->string('subject', 50);
            $table->text('content_addressed_to'); // to whom the email should be addressed to
            $table->text('content');
            $table->string('template', 20)->nullable();

            $table->text('error')->nullable();
            $table->integer('retry_count')->default(0);

            $table->integer('organization_id')->unsigned()->nullable(true);
            $table->integer('status')->default(0); //0- not sent out, 1 - sent out

            //Foreign keys
         
            // Common Fields and foreign keys
            $table->integer('created_by', false)->unsigned()->nullable();
            $table->integer('last_modified_by', false)->unsigned()->nullable();
            $table->timestamps();

            $table->integer('deleted_by', false)->unsigned()->nullable();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on(pBusinessDBName() . '.organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('persons')->onDelete('restrict');
            $table->foreign('last_modified_by')->references('id')->on('persons')->onDelete('restrict');
            $table->foreign('deleted_by')->references('id')->on('persons')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emailnotifications');
    }
}
