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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->foreignId('day_id')->nullable()
            ->constrained('days')
            ->onDelete('set null')
            ->onUpdate('cascade');
            $table->foreignId('action_id')->nullable()
            ->constrained('actions')
            ->onDelete('set null')
            ->onUpdate('cascade');
            $table->foreignId('group_id')->nullable()
            ->constrained('groups')
            ->onDelete('set null')
            ->onUpdate('cascade');
            $table->timestamps();

            $table->unique(['day_id', 'action_id', 'group_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
