<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadAppliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('read_appliances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appliance_id');
            $table->unique('appliance_id');
            $table->string('external_id');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->string('category');
            $table->integer('price_amount');
            $table->string('price_currency');
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
        Schema::dropIfExists('read_appliances');
    }
}
