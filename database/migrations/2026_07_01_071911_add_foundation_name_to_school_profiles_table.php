<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->string('foundation_name')->nullable()->after('school_name');
        });
    }

    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn('foundation_name');
        });
    }
};
