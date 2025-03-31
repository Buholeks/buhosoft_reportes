<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_sucursal')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->string('nombre', 255)->nullable();
            $table->string('correo', 45)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('calle', 255)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('codigo_postal', 20)->nullable();
            $table->string('pais', 100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
