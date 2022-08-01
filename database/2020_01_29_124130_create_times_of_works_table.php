<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesOfWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times_of_works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day');
            $table->boolean('holiday'); // true holiday day - // false work
            $table->time('from');
            $table->time('to');
            $table->integer('doctor_lawyer_id');
            $table->integer('count')->nullable(); // count of maximum reservation in this period
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times_of_works');
    }
}
