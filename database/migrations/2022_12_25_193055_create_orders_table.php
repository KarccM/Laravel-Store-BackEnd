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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->timestamps();
            $table->foreignId('client_id');
            $table->foreignId('user_id');
            $table->foreignId('invoic_id');
            $table->foreignId('sold_items_id');
            $table->enum('status',['completed', 'shipped', 'pendding']);
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
};
