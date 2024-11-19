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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('nombre');
            $table->string('descripcionc');
            $table->string('descripcionl');
            $table->integer('precioneto');
            $table->integer('stockactual');
            $table->integer('stockminimo');
            $table->integer('stockbajo');
            $table->integer('stockalto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
