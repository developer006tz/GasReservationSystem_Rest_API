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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('gases_posts','id')->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->double('price')->default(0.00);
            $table->double('total_amount')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
