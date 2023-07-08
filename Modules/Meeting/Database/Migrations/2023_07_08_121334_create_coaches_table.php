<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar');
            $table->unsignedBigInteger('hourly_price');
            $table->tinyInteger('status')->default(0);
            $table->foreignId('user_id')->constrained('users');

//            $table->foreignId('category_id')->constrained('')
//            $table->foreignId('coach_info')
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
        Schema::dropIfExists('coaches');
    }
};
