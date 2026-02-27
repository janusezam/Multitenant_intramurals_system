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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->foreignId('sport_id')
                ->constrained('sports')
                ->onDelete('cascade');
            $table->string('name', 100);
            $table->unsignedBigInteger('coach_id')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('color', 7)->nullable();
            $table->enum('status', ['active', 'disqualified', 'withdrawn'])->default('active');
            $table->timestamps();

            $table->foreign('coach_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index('university_id');
            $table->index('sport_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
