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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->foreignId('sport_id')
                ->constrained('sports')
                ->onDelete('cascade');
            $table->foreignId('team_id')
                ->constrained('teams')
                ->onDelete('cascade');
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('draws')->default(0);
            $table->integer('points')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->timestamps();

            $table->unique(['sport_id', 'team_id']);
            $table->index('university_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
