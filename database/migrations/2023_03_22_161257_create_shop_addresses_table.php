<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->text('address');
            $table->text('country_region');
            $table->text('province');
            $table->text('city');
            $table->text('area');
            $table->foreign('shop_id')->on('shops')->references('id')->onDelete('CASCADE');
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
        Schema::dropIfExists('shop_addresses');
    }
};
