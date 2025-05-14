<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_category_id'); // Foreign key reference
            $table->string('name');
            $table->string('slug')->unique(); // Slug field added
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('main_category_id')
                  ->references('id')->on('main_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
}
