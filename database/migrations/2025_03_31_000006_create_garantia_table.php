<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('garantia', function (Blueprint $table) {
                        $table->bigIncrements('idtablagarantia');
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_sucursal')->nullable();
            $table->bigInteger('id_empleado')->nullable();
            $table->bigInteger('id_cliente')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->string('imei', 45)->nullable();
            $table->string('marca', 255)->nullable();
            $table->text('fallo')->nullable();
            $table->text('accesorios')->nullable();
            $table->text('solucion')->nullable();
            $table->string('estado', 45)->nullable();
            $table->timestamp('created_at')->nullable()->nullable();
            $table->timestamp('updated_at')->nullable()->nullable();
                        $table->foreign('id_empleado')->references('id')->on('tablaempleados');
            $table->foreign('id_empresa')->references('id')->on('tablaempresas');
            $table->foreign('id_sucursal')->references('id')->on('tablasucursal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garantia');
    }
};
