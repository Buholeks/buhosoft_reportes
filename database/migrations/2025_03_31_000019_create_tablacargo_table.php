<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablacargo', function (Blueprint $table) {
                        $table->bigIncrements('id');
            $table->string('descripcion', 45)->nullable();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablacargo');
    }
};
