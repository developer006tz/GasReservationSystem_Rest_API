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
        Schema::create('gases_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gas_category_id')->constrained('gas_categories','id')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->double('price');
            $table->integer('in_stock')->default(0);
            $table->foreignId('supplier_id')->constrained('users','id')->cascadeOnDelete();
            $table->enum('is_published',['yes','no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gases');
    }
};
