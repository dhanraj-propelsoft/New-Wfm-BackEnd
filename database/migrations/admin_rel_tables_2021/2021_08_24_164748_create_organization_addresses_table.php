<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    if (App::environment('local')) {
                // The environment is local
                Schema::disableForeignKeyConstraints();
                $this->down();
                Schema::enableForeignKeyConstraints();
            }

        Schema::connection(pBusinessDBConnectionName())->create('organization_addresses', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('organization_id')->unsigned()->nullable(false);
             $table->integer('address_type_id')->unsigned()->nullable(false);
             $table->integer('door_no')->nullable(true);
             $table->string('building_name')->nullable(true);
             $table->string('street')->nullable(true);
             $table->string('area')->nullable(true);
             $table->integer('city_id', false)->unsigned()->nullable(true);
             $table->integer('pin')->nullable(true);
             $table->string('phone', false)->nullable(true);
             $table->string('landmark', false)->nullable(true);
             $table->string('google_location', false)->nullable(true);
             $table->integer('status_id', false)->unsigned()->nullable(false);
   //Common Fields and foreign keys
              $table->integer('created_by', false)->unsigned()->nullable();
              $table->integer('last_modified_by', false)->unsigned()->nullable();
              $table->timestamps();
              $table->integer('deleted_by', false)->unsigned()->nullable();
              $table->softDeletes();

 //Foreign keys
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict');
            $table->foreign('address_type_id')->references('id')->on(pCommonDBName() .'address_types')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on(pCommonDBName() .'status_categories')->onDelete('restrict');
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
        Schema::connection(pBusinessDBConnectionName())->dropIfExists('organization_addresses');
    }
}
