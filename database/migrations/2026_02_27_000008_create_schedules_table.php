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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->foreignId('sport_id')
                ->constrained('sports')
                ->onDelete('cascade');
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');
            $table->dateTime('scheduled_at');
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();

            $table->foreign('venue_id')
                ->references('id')
                ->on('venues')
                ->onDelete('set null');

            $table->foreign('home_team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

            $table->foreign('away_team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

            $table->index('university_id');
            $table->index('sport_id');
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
