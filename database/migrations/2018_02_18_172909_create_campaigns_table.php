<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->onDelete('cascade');
            $table->integer('map_id')->unsigned()->onDelete('cascade')->nullable();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('map_id')->references('id')->on('maps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
