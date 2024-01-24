<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("brand", 20)->nullable();
            $table->string("model", 40)->nullable();
            $table->unsignedInteger("year");
            $table->string("renavam", 11);
            $table->string("plate", 10);
            $table->string("color", 20)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
