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
        Schema::create('brackets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->foreignId('sport_id')
                ->constrained('sports')
                ->onDelete('cascade');
            $table->string('name', 100);
            $table->enum('type', ['single_elimination', 'double_elimination', 'round_robin'])->default('single_elimination');
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
            $table->timestamps();

            $table->index('university_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brackets');
    }
};
