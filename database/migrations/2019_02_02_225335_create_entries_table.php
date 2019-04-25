<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Mandatory fields
            $table->string('entryid', 200)->nullable(false);
            $table->string('title', 200)->nullable(false);
            $table->timestamp('updated')->nullable(false);

            // Recomended Fields
            $table->text('content')->nullable();
            $table->string('summary', 2000)->nullable();
            $table->timestamp('published')->nullable();
            $table->string('rights', 200)->nullable();


            $table->unsignedBigInteger('feed_id');
            $table->unsignedInteger('source_id');

            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
