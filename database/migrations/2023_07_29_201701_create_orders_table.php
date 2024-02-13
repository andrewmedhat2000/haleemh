<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->bigInteger('days');
            $table->decimal('long');
            $table->decimal('lat');
            $table->bigInteger('hours');
            $table->bigInteger('parent_id')->unsigned();
            $table->bigInteger('setter_id')->unsigned();
            $table->bigInteger('driver_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('parents')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('setter_id')->references('id')->on('setter')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
