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
        Schema::create('opf_items', function (Blueprint $table) {
            $table->id();
            $table->string('opf_id');
            $table->string('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('part_id')->nullable();
            $table->string('part_description')->nullable();
            $table->string('part_name')->nullable();
            $table->decimal('unit_cost','10','2')->nullable();
            $table->string('qty')->nullable();
            $table->string('part_comment')->nullable();
            $table->decimal('freight','10','2')->nullable();
            $table->decimal('unit_selling_price','10','2')->nullable();
            $table->decimal('taxes','10','2')->nullable();
            $table->decimal('total_selling_price','10','2')->nullable();
            $table->decimal('total_cost','10','2')->nullable();
            $table->decimal('freight_cost','10','2')->nullable();
            $table->decimal('taxes_cost','10','2')->nullable();
            $table->decimal('unit_landed_cost','10','2')->nullable();
            $table->decimal('profit','10','2')->nullable();
            $table->decimal('margin','10','2')->nullable();
            $table->decimal('currency','10','2')->nullable();
            $table->boolean('stock_check')->nullable();
            $table->boolean('po_check')->nullable();
            $table->string('po_number')->nullable();
            $table->boolean('gr_check')->nullable();
            $table->boolean('is_poison')->nullable();
            $table->string('gr_number')->nullable();
            $table->string('total_gr_check')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opf_items');
    }
};
