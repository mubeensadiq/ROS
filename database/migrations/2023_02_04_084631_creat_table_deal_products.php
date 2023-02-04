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
        Schema::create('deal_products' , function(Blueprint $table){
            $table->foreignId('deal_id')
                ->constrained('deals')
                ->onDelete('cascade');
            $table->foreignId('category_id')
                ->nullable()
                ->constrained();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained();
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_products');
    }
};
