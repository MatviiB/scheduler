<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
