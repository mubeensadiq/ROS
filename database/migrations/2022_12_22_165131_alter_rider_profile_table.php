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
        Schema::table('rider_profile', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropColumn(['area_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rider_profile', function (Blueprint $table) {
            $table->foreignId('area_id')
                ->constrained('areas')
                ->nullOnDelete();
        });
    }
};
