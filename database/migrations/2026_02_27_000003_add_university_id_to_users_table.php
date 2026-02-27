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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('university_id')->nullable()->after('id');
            $table->string('student_id', 50)->nullable()->after('university_id');
            $table->string('profile_photo', 255)->nullable()->after('password');

            $table->foreign('university_id')
                ->references('id')
                ->on('universities')
                ->onDelete('set null');

            $table->index('university_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropIndex(['university_id']);
            $table->dropColumn(['university_id', 'student_id', 'profile_photo']);
        });
    }
};
