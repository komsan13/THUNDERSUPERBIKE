<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateTbTestForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_test_form', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("image",100)->nullable();
            $table->string("name",100)->nullable();
            $table->text("detail")->nullable();

            $table->integer('sort')->nullable();
            $table->enum("status",['on','off'])->nullable();
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
        Schema::dropIfExists('tb_test_form');
    }
}
