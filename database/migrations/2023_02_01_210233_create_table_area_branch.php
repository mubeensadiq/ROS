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
        Schema::create('area_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')
                ->constrained('areas')
                ->onDelete('cascade');
            $table->foreignId('branch_id')
                ->constrained('branches')
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
        Schema::dropIfExists('area_branch');
    }
};
