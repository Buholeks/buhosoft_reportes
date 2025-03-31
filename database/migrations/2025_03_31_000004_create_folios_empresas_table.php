<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('folios_empresas', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('empresa_id');
            $table->bigInteger('ultimo_folio')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                        $table->foreign('empresa_id')->references('id')->on('tablaempresas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folios_empresas');
    }
};
