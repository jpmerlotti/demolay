<?php

use App\Models\User;
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
        Schema::create('demolays', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('sisdm')->unique()->nullable();
            $table->dateTime('birthdate');
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(User::class, 'user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demolays');
    }
};
