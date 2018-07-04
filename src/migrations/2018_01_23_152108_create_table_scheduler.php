<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableScheduler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('scheduler.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('command', 128);
            $table->string('default_parameters', 128)->nullable();
            $table->string('arguments', 128)->nullable();
            $table->string('options', 128)->nullable();
            $table->tinyInteger('is_active');
            $table->string('expression', 32);
            $table->string('description', 512);
            $table->dateTime('last_execution')->nullable();
            $table->tinyInteger('without_overlapping')->dafault(0);
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
        Schema::dropIfExists(config('scheduler.table'));
    }
}
