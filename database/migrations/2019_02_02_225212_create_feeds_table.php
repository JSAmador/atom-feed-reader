<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Mandatory fields
            $table->string('entryid', 200)->nullable(false);
            $table->string('title', 200)->nullable(false);
            $table->timestamp('updated')->nullable(false);

            // Optional fields
            $table->string('icon', 200)->nullable();
            $table->string('logo', 200)->nullable();
            $table->string('rights', 200)->nullable();
            $table->string('subtitle', 200)->nullable();

            $table->unsignedInteger('generator_id');
            $table->unsignedInteger('added_by');

            $table->foreign('generator_id')->references('id')->on('generators')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
