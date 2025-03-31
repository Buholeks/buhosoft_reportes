<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tabla_metodopagos', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->nullable();
            $table->string('nombre', 45)->nullable();
            $table->string('descripcion', 45)->nullable();
                        $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabla_metodopagos');
    }
};
