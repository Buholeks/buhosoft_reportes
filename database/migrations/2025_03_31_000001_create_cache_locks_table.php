<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cache_locks', function (Blueprint $table) {
                        $table->string('key', 255);
            $table->string('owner', 255);
            $table->bigInteger('expiration');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cache_locks');
    }
};
