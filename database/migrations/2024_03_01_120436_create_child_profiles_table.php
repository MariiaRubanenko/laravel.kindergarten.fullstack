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
        Schema::create('child_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender'); // поле пол
            $table->date('birthday'); // день рождения
            $table->text('allergies')->nullable(); // аллергии
            $table->text('illnesses')->nullable(); // болезни
            $table->foreignId('family_account_id')->nullable()
            ->constrained('family_accounts')
            ->onDelete('set null')
            ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_profiles');
    }
};
