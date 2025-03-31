<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablaempleados', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->string('nombre', 45)->nullable();
            $table->bigInteger('id_sucursal')->nullable();
            $table->bigInteger('id_empresa')->nullable();
                        $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_sucursal')->references('id')->on('tablasucursal')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablaempleados');
    }
};
