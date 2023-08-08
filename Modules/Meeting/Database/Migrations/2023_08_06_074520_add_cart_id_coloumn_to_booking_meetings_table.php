<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Facades\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_meetings', function (Blueprint $table) {
            if (Module::has('Payment')){
                $table->unsignedBigInteger('cart_id')->after('amount');
                $table->foreign('cart_id')->references('id')->on('carts');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_meetings', function (Blueprint $table) {
            if (Module::has('Payment'))
                $table->dropIfExists('cart_id');
        });
    }
};
