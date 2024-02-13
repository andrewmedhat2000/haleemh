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
        Schema::create('nursery_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('num_of_stars', 8, 2);
            $table->text('review');
            $table->bigInteger('nursery_id')->unsigned();
            $table->foreign('nursery_id')->references('id')->on('nursery')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursery_rates');
    }
};
