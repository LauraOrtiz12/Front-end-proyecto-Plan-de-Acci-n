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
            $table->text('observation_goal')->nullable();
            $table->text('justification_goals_budget')->nullable();
            $table->text('follow_up_observation')->nullable();
            $table->text('follow_up_justify_indicator')->nullable();
            $table->text('justification_monitoring_budget')->nullable();
            $table->date('initial_date');
            $table->date('final_date');
            $table->text('physical_resource')->nullable();
            $table->text('technical_resource')->nullable();
            $table->text('human_resource')->nullable();
            $table->text('responsible_indicator')->nullable();
            $table->text('responsible_position_indicator')->nullable();
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
