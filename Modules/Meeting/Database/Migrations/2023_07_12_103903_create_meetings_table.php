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
        Schema::create('meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('body')->nullable();
            $table->string('category')->nullable();
            $table->boolean('isAllDay')->default(false);
            $table->date('end');
            $table->time('endTime')->nullable();
            $table->date('start');
            $table->time('startTime')->nullable();
            $table->foreignId('coach_id')->constrained('coaches');

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
        Schema::dropIfExists('meetings');
    }
};
