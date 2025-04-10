<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablaequipos', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_sucursal')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->bigInteger('id_vendedor')->nullable();
            $table->string('folio_empresa', 20)->nullable();
            $table->string('folio_sucursal', 20)->nullable();
            $table->string('imei', 45)->nullable();
            $table->string('marca', 45)->nullable();
            $table->bigInteger('tipoeq')->nullable();
            $table->string('tipove', 45)->nullable();
            $table->decimal('precio', 8, 2)->nullable();
            $table->string('enganche', 45)->nullable();
            $table->string('numero', 45)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                        $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_sucursal')->references('id')->on('tablasucursal')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_vendedor')->references('id')->on('tablaempleados')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablaequipos');
    }
};
