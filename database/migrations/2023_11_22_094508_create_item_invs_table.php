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
        Schema::create('item_invs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('part_number')->nullable();
            $table->string('description')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('base_rate',6,2)->nullable();
            $table->decimal('price',6,3)->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_invs');
    }
};
