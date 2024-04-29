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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->char('numero',3);
            $table->char('placa',7);
            $table->boolean('activo')->nullable()->default(false);
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->foreignId('statu_id')->nullable()->constrained('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
