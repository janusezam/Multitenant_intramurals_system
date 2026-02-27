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
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->foreignId('schedule_id')
                ->constrained('schedules')
                ->onDelete('cascade');
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->unsignedBigInteger('winner_team_id')->nullable();
            $table->boolean('is_draw')->default(false);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->timestamps();

            $table->foreign('winner_team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null');

            $table->foreign('recorded_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index('university_id');
            $table->index('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
