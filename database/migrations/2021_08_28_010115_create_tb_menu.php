<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('_id')->nullable();
            $table->string('name',100)->nullable();
            $table->text('url')->nullable();
            $table->text('icon')->nullable();
            $table->enum('position',['main','secondary'])->nullable();


            $table->integer('sort')->nullable();
            $table->enum('status',['on','off'])->nullable()->default('on');
            $table->enum('delete_status',['on','off'])->nullable()->default('off');
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
            $table->datetime('deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_menu');
    }
}
