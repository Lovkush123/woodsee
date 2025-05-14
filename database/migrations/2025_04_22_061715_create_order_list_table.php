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
        Schema::create('order_list', function (Blueprint $table) {
            $table->id(); // Default primary key 'id' (auto-increment)
            $table->unsignedBigInteger('user_id');
            
            // Store order_id and related reference id (not enforced with FK)
            $table->string('order_id')->unique();
            $table->unsignedBigInteger('order_ref_id'); // Just a reference, no FK

            $table->string('status', 50);
            $table->decimal('amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('delivery_charges', 10, 2)->default(0.00);
            $table->timestamps();

            // Optional user relation (still commented out)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_list');
    }
};
