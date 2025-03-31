<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablarecarga', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_sucursal')->nullable();
            $table->bigInteger('id_empleado')->nullable();
            $table->string('rec_anterior', 45)->nullable();
            $table->string('dep_recibido', 45)->nullable();
            $table->string('rec_hoy', 45)->nullable();
            $table->string('dep_enviado', 45)->nullable();
            $table->string('vendido', 45)->nullable();
            $table->date('fecha')->nullable();
                        $table->foreign('id_empleado')->references('id')->on('tablaempleados')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_sucursal')->references('id')->on('tablasucursal')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablarecarga');
    }
};
