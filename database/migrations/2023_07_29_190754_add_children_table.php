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
        Schema::create('childrens', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('nationality')->nullable();
        $table->string('hobby')->nullable();
        $table->string('image')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->bigInteger('parent_id')->unsigned();
        $table->foreign('parent_id')->references('id')->on('parents')
            ->onUpdate('cascade')->onDelete('cascade');
        $table->tinyInteger('is_diseased')->nullable()->default(0);
        $table->string('disease')->nullable();
        $table->enum('gender', ['male', 'female']);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
