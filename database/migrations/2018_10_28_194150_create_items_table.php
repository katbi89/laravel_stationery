<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 200)->unique();

            $table->text('description')->nullable();

            $table->text('image')->nullable();

            $table->bigInteger('amount')->default('0');

            $table->text('notes')->nullable();

            $table->integer('tree_id')->unsigned();
            $table->foreign('tree_id')->references('id')->on('trees');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
