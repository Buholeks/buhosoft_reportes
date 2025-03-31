<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listadeprecios', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->nullable();
            $table->string('descripcion', 45)->nullable();
            $table->string('tipoe', 45)->nullable();
            $table->string('tipove', 45)->nullable();
            $table->decimal('precio', 8, 2)->nullable();
            $table->decimal('precio_promocion', 8, 2)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                        $table->foreign('id_empresa')->references('id')->on('tablaempresas')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listadeprecios');
    }
};
