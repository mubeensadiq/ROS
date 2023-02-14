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
        Schema::dropIfExists('addon_categories');
        Schema::create('addon_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->timestamps();
        });
        Schema::table('addons', function (Blueprint $table){
            $table->foreignId('addon_category_id')
                ->constrained('addon_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('addon_categories');
        Schema::table('addons', function (Blueprint $table){
            $table->dropConstrainedForeignId('addon_category_id');
        });
    }
};
