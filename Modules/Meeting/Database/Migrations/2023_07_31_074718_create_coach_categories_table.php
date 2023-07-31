<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->nestedSet();
            $table->boolean('is_visible')->default(false);
            $table->timestamps();

            $table->index(['slug', 'name']);
        });

        Schema::create('category_coach', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('coach_id');
//            $table->foreignId('category_id')->constrained('coach_categories');
//            $table->foreignId('coach_id')->constrained('coaches');
            $table->primary(['coach_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coach_categories');
        Schema::dropIfExists('category_coach');
    }
};
