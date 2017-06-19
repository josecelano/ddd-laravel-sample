<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplianceReadModelWishlistReadModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance_wishlist_read_model', function (Blueprint $table) {

            $table->integer('wishlist_id')->unsigned()->nullable();
            $table->foreign('wishlist_id')->references('id')
                ->on('read_wishlists')->onDelete('cascade');

            $table->integer('appliance_id')->unsigned()->nullable();
            $table->foreign('appliance_id')->references('id')
                ->on('read_appliances')->onDelete('cascade');

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
        Schema::dropIfExists('appliance_wishlist_read_model');
    }
}
