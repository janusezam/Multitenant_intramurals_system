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
        Schema::create('bracket_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->foreignId('bracket_id')
                ->constrained('brackets')
                ->onDelete('cascade');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->integer('round');
            $table->integer('match_order')->default(1);
            $table->unsignedBigInteger('team_a_id')->nullable();
            $table->unsignedBigInteger('team_b_id')->nullable();
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->unsignedBigInteger('next_match_id')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'completed'])->default('pending');
            $table->timestamps();

            $table->foreign('schedule_id')
                ->references('id')
                ->on('schedules')
                ->onDelete('set null');

            $table->foreign('team_a_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null');

            $table->foreign('team_b_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null');

            $table->foreign('winner_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null');

            $table->index('university_id');
            $table->index('bracket_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bracket_matches');
    }
};
