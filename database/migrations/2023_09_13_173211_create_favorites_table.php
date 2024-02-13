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
            Schema::create('favorites', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('setter_id');
                $table->unsignedBigInteger('parent_id');
                $table->timestamps();  
                $table->foreign('setter_id')->references('id')->on('setter')->onDelete('cascade');
                $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
                $table->unique(['setter_id', 'parent_id']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
