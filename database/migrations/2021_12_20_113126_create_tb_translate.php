<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTranslate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_translate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comment')->nullable();
            $table->text('name_th')->nullable();
            $table->text('name_en')->nullable();

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
        Schema::dropIfExists('tb_translate');
    }
}
