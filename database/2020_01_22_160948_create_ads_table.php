<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 300); // Image Name
            $table->string('type', 20); // type of ad maybe link outside the application or profile id (link / id)
            $table->text('content'); // the value of the type maybe link or the id
            $table->string('adownertype' , 20); // the type of the ad owner (doctor / lawyer)
            $table->integer('place'); // (1 / 2) 1 -> ads that appears before selecting doctor or lawyer -- 2 -> ads that appears after selecting 
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
        Schema::dropIfExists('ads');
    }
}
