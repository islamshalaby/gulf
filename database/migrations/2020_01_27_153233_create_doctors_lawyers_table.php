<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsLawyersTable extends Migration
{
    /**
     * Run the migrations.Reservation
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors_lawyers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('app_name_en'); // displays in app
            $table->string('app_name_ar');
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->string('professional_title_en');
            $table->string('professional_title_ar');
            $table->string('image_professional_title');
            $table->string('image_profession_license');
            $table->string('personal_image');
            $table->text('about_en');
            $table->text('about_ar');
            $table->string('city_en');
            $table->string('city_ar');
            $table->text('address_en');
            $table->text('address_ar');
            $table->integer('reservation_cost');
            $table->string('recieving_reservation_phone');
            $table->boolean('gender'); // true -> male , false -> female
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('category_id');
            $table->string('type'); // doctor or lawyer
            $table->boolean('active')->default(true); // true -> active -- false -> blocked
            $table->integer('profile_completed'); // 1 waiting admin approval 
                                                  // 2 admin accepted ( waiting fill out times of work )
                                                  // 3 working time filled out profile completed
            $table->string('reservation_type'); // maybe attendance or intime 
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
        Schema::dropIfExists('doctors_lawyers');
    }
}
