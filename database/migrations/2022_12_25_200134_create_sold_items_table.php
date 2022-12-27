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
        Schema::create('solditems', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('order_id');
            $table->foreignId('item_id');
            $table->foreignId('invoice_id');
            $table->integer('price_at_moment');
            $table->string('name_at_moment');
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
        Schema::dropIfExists('solditems');
    }
};
