<?php

use App\Enums\RolesEnum;
use App\Models\Demolay;
use App\Models\Leading;
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
        Schema::create('leading_bodys', function (Blueprint $table) {
            $table->foreignIdFor(Leading::class, 'leading_id');
            $table->foreignIdFor(Demolay::class, 'demolay_id');
            $table->enum('role', array_column(RolesEnum::cases(), 'value'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leading_bodys');
    }
};
