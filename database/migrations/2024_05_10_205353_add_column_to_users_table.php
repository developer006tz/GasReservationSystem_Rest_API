<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',20)->nullable();
            $table->enum('user_ype',['supplier','client'])->default('client');
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
