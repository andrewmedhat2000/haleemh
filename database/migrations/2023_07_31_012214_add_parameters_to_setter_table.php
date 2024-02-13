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
        Schema::table('setter', function (Blueprint $table) {
            $table->bigInteger('nursery_id')->unsigned()->nullable();
            $table->foreign('nursery_id')->references('id')->on('nursery')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('Professional_life', ['freelance', 'nursery'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setter', function (Blueprint $table) {
            $table->dropColumn('nursery_id');
            $table->dropColumn('Professional_life');
        });
    }
};
