<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablaempresas', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->string('nom_empresa', 250)->nullable();
            $table->string('nombre_dueño', 250)->nullable();
            $table->string('direccion', 45)->nullable();
            $table->string('logo')->nullable();
            $table->string('prefijo_folio_empresa', 10)->nullable();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablaempresas');
    }
};
