<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('time');
            $table->integer('cost');
            $table->integer('status'); // 1 -> reservation created
                                       // 2 ->  reservation completed (user attend)
                                       // 3 -> visit rated (end)
                                       // 4 -> the doctor or lawyer say that the user not come
                                       // 5 -> reservation cancelled from user
                                       // 6 -> reservation cancelled from doctor

            $table->string('payment_method'); // online or wallet or cash
            $table->string('user_name');
            $table->string('phone');
            $table->boolean('user_confirm')->nullable(); // true -> user confirm attendance , false -. He confirmed that he did not attend
            $table->integer('work_time_id');
            $table->integer('user_id');
            $table->integer('doctor_lawyer_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('address_en');
            $table->text('address_ar');
            $table->string('city_ar');
            $table->string('city_en');
            $table->string('reservation_for'); // may be accountowner or someoneelse
            $table->text('user_cancell_reason')->nullable();
            $table->string('type'); // doctor or lawyer
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
        Schema::dropIfExists('reservations');
    }
}
