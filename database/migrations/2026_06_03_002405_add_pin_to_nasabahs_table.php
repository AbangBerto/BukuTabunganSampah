<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            // Menambahkan kolom PIN, default 123456
            $table->string('pin', 6)->default('123456')->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->dropColumn('pin');
        });
    }
};