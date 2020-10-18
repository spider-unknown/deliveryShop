<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('total_quantity');
            $table->float('total_amount');
            $table->integer('status');
            $table->boolean('courier');
            $table->boolean('cash');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('user_address_id')->constrained('user_addresses', 'id');
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
        Schema::dropIfExists('orders');
    }
}
