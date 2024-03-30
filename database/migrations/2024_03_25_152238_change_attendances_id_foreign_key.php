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
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['child_profile_id']);
            $table->dropColumn('child_profile_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('child_profile_id')->nullable()
                ->constrained('child_profiles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['child_profile_id']);
            $table->dropColumn('child_profile_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('child_profile_id')->nullable()
                ->constrained('child_profiles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
};
