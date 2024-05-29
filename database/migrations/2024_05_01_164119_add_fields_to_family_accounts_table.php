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
        Schema::table('family_accounts', function (Blueprint $table) {

            $table->string('image_name')->nullable();
            $table->binary('image_data')->nullable();
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_accounts', function (Blueprint $table) {
            
            $table->dropColumn('image_name');
            $table->dropColumn('image_data');
            $table->dropColumn('phone_number');
        });
    }
};
