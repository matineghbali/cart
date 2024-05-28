<?php

use App\Models\Cart;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->enum('status', Cart::ALL_STATUSES);
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('token', 50);
            $table->unsignedInteger('total_price');
            $table->index(['user_id', 'token']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
