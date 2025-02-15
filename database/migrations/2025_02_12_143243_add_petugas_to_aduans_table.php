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
        Schema::table('aduans', function (Blueprint $table) {
            $table->unsignedBigInteger('petugas_id')->nullable()->after('status');
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('set null');
            $table->date('jadwal_survei')->nullable()->after('petugas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn(['petugas_id', 'jadwal_survei']);
        });
    }
};
