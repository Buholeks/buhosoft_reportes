<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('model_has_roles', function (Blueprint $table) {
                        $table->bigInteger('role_id');
            $table->string('model_type', 255);
            $table->bigInteger('model_id');
                        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};
