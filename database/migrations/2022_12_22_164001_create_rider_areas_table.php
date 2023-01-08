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
        Schema::create('rider_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_id')
                ->constrained('rider_profile')
                ->onDelete('cascade');
            $table->foreignId('area_id')
                ->constrained('areas')
                ->onDelete('cascade');
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
        Schema::dropIfExists('user_areas');
    }
};
