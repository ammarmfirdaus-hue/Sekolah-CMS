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
        Schema::create('documentation_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documentation_event_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['photo', 'video_embed']);
            $table->string('path')->nullable();
            $table->string('embed_url')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index('documentation_event_id');
            $table->index('type');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentation_media');
    }
};
