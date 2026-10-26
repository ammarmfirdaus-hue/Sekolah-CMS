<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_information', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('process')->nullable();
            $table->longText('schedule')->nullable();
            $table->text('contact_info')->nullable();
            $table->boolean('is_open')->default(true);
            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_information');
    }
};
