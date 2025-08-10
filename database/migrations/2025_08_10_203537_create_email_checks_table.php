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
        Schema::create('email_checks', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->boolean('is_valid')->default(false);
            $table->string('reason')->nullable();      // e.g. invalid_format, no_mx, smtp_fail, etc.
            $table->json('meta')->nullable();          // detalles: dominios MX, tiempos, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_checks');
    }
};
