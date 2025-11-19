<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('user_id')->constrained('users');

            $table->enum('type', [
                'inbound',
                'outbound_recipe',
                'outbound_waste',
                'stock_opname',
                'adjustment'
            ]);

            $table->decimal('quantity_change', 15, 4);

            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
