<?php


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationQualificationsTable extends Migration
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
        Schema::create('education_qualifications', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('qualification_name', 50); 
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
        Schema::dropIfExists('education_qualifications');
    }
}
