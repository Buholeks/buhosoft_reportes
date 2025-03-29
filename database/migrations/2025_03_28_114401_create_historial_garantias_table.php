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
        Schema::create('historial_garantias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garantia_id')->constrained('garantias')->onDelete('cascade');
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // quién hizo el cambio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('historial_garantias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garantia_id')->constrained('garantias')->onDelete('cascade');
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // quién hizo el cambio
            $table->timestamps();
        });
    }
};
