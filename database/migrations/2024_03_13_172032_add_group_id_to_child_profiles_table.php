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
        Schema::table('child_profiles', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('group_id')->nullable();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('child_profiles', function (Blueprint $table) {
            
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};
