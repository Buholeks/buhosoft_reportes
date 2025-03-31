<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historial_garantias', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->bigInteger('garantia_id');
            $table->string('estado_anterior', 255)->nullable();
            $table->string('estado_nuevo', 255);
            $table->bigInteger('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                        $table->foreign('garantia_id')->references('idtablagarantia')->on('garantia')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_garantias');
    }
};
