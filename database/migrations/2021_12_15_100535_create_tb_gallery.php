<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("_id")->nullable();
            $table->string("type",50)->nullable();
            $table->string("image",100)->nullable();
            $table->text("image_real_name")->nullable();
       
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_gallery');
    }
}
