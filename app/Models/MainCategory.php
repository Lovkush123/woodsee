<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainCategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('main_category', function (Blueprint $table) {
            $table->id(); // Auto-increment id
            $table->string('name'); // name field
            $table->string('slug')->unique(); // slug field, must be unique
            $table->text('description')->nullable(); // description field, nullable
            $table->string('image')->nullable(); // image field, nullable
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_category');
    }
}
