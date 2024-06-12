<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('indicator', 20);
            $table->string('name_indicator', 500);
            $table->text('perspective')->nullable();
            $table->string('name_perspective', 500)->nullable();
            $table->string('objective_strategy')->nullable();
            $table->string('name_strategy')->nullable();
            $table->string('indicator_strategy')->nullable();
            $table->string('name_indicator_strategy')->nullable();
            $table->string('area', 500)->nullable();
            $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
