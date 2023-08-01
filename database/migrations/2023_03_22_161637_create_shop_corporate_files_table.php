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
        Schema::create('shop_corporate_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->text('legal_name');
            $table->text('pan_no');
            $table->text('image');
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
        Schema::dropIfExists('shop_corporate_files');
    }
};
