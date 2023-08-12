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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('city')->after('order_type');
            $table->integer('area')->nullable()->after('city');
            $table->integer('branch')->nullable()->after('area');
            $table->integer('rider')->nullable()->after('branch');
            $table->integer('cancel_reason')->nullable()->after('status');
            $table->integer('delivery_charges')->default(0)->after('tax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('area');
            $table->dropColumn('branch');
            $table->dropColumn('rider');
            $table->dropColumn('cancel_reason');
            $table->dropColumn('delivery_charges');
        });
    }
};
