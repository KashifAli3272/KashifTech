<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->default('code');         // icon key: code, palette, share, etc.
            $table->string('icon_bg')->default('#eef2ff');   // background hex color
            $table->string('icon_color')->default('#4f46e5'); // icon stroke hex color
            $table->json('tags')->nullable();                // ["React", "Next.js", "E-commerce"]
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);       // for drag-and-drop reordering later
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
