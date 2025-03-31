<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablasucursal', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->nullable();
            $table->string('nombre', 200)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('numero_tel', 45)->nullable();
            $table->string('prefijo_folio_sucursal', 10)->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
                        $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablasucursal');
    }
};
