<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');

            // Mandatory fields
            $table->string('href', 200)->nullable(false);

            // Optional fields
            $table->string('rel', 200)->nullable();
            $table->string('type', 200)->nullable();
            $table->string('hreflang', 200)->nullable();
            $table->string('title', 200)->nullable();
            $table->string('length', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
