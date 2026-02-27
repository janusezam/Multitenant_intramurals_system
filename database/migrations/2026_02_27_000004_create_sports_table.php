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
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')
                ->constrained('universities')
                ->onDelete('cascade');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->enum('category', ['team', 'individual'])->default('team');
            $table->enum('bracket_type', ['single_elimination', 'double_elimination', 'round_robin'])->default('single_elimination');
            $table->unsignedBigInteger('facilitator_id')->nullable();
            $table->integer('max_teams')->default(8);
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->string('logo', 255)->nullable();
            $table->timestamps();

            $table->foreign('facilitator_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index('university_id');
            $table->index('facilitator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
