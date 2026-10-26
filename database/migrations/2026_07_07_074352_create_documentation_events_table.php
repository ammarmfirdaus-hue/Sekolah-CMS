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
        Schema::create('documentation_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('event_date');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->nullable();
            $table->timestamps();

            $table->index('event_date');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentation_events');
    }
};
