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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validity_id')->constrained();
            $table->foreignId('estate_id')->constrained();
            $table->integer('cicle')->default(1)->comment("1 Responsabe, 2 Seguimiento, 3 Seguimiento II");
            $table->enum('justify_status', ['Activo', 'Borrador', 'Enviado'])->default('Activo')->comment("Activo, Borrador, Enviado");
            $table->text('justify_estate_indicator')->nullable();
            $table->text('justify_estate_money')->nullable();
            $table->text('observation_control')->nullable();
            $table->foreignId('responsible_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->bigInteger('advisor_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
