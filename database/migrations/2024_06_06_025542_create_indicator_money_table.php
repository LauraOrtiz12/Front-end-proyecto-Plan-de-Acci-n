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
        Schema::create('indicator_money', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validity_id')->constrained();
            $table->foreignId('estate_id')->constrained();
            $table->string('siif', 10);
            $table->string('project_id', 100)->default('0');
            $table->string('open_money', 100)->default('0');
            $table->string('commitment', 100)->default('0');
            $table->string('payments', 100)->default('0');
            $table->string('commitment_percentage', 100)->default('0');
            $table->string('payment_execution', 100)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_money');
    }
};
