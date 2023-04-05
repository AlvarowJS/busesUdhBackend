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
        Schema::create('status_drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drivers_id')->nullable()->constrained('drivers');
            $table->foreignId('status_id')->nullable()->constrained('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_drivers');
    }
};
