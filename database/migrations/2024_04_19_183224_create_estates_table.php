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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_reg');
            $table->integer('cod_dep');
            $table->string('dependence');
            $table->foreignId('responsible_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreignId('adviser_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
