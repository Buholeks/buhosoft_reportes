<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chip', function (Blueprint $table) {
                        $table->bigIncrements('idtablachip');
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_sucursal')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_vendedor')->nullable();
            $table->string('numero', 45)->nullable();
            $table->string('iccid', 45)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                        $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_sucursal')->references('id')->on('tablasucursal')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_vendedor')->references('id')->on('tablaempleados');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chip');
    }
};
