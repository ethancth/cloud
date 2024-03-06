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
        Schema::create('opfs', function (Blueprint $table) {
            $table->id();
            $table->string('opf_no')->nullable()->unique();
            $table->string('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('po_value')->nullable();
            $table->boolean('status')->default(true);
            $table->string('sales_person')->nullable();
            $table->string('current_division')->nullable();
            $table->string('gr_status')->nullable();
            $table->string('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opfs');
    }
};
