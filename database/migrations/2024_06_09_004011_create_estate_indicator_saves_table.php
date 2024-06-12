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
        Schema::create('estate_indicator_saves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validity_id')->constrained();
            $table->foreignId('estate_id')->constrained();
            $table->foreignId('indicator_id')->constrained();
            $table->foreignId('follow_close_id')->constrained();
            $table->string('month', 15);
            $table->string('start_date', 30);
            $table->string('end_date', 30);
            $table->string('goal', 30);
            $table->string('execution_goals', 30);
            $table->string('expected_goal', 30)->default('0');
            $table->string('cicly_indicator', 5)->comment('1: En el dependencia, 2: Control 1, 3: Control 2 (Asesor), 4: Digeneral Admin');
            $table->text('physical_recursion')->nullable();
            $table->text('technical_recursion')->nullable();
            $table->text('human_resource')->nullable();
            $table->text('responsible_indicator')->nullable();
            $table->text('post_responsible_indicator')->nullable();
            $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_indicator_saves');
    }
};
