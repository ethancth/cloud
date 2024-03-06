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
        Schema::table('opfs', function (Blueprint $table) {
            //
          $table->string('customer_delivery_address')->nullable();
          $table->string('customer_billing_address')->nullable();
          $table->string('total_po')->default('0')->nullable();
          $table->string('total_cost_of_goods')->default('0')->nullable();
          $table->string('total_tax')->default('0')->nullable();
          $table->string('total_shipping')->default('0')->nullable();
          $table->string('gross_profit')->default('0')->nullable();
          $table->string('gross_profit_percent')->default('0')->nullable();
          $table->string('grn_status')->nullable();
          $table->string('grn_rate')->nullable();
          $table->string('opf_status')->default('draft');
          $table->string('submitted_by')->nullable();
          $table->string('approve_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opfs', function (Blueprint $table) {
            //
          $table->dropColumn(array_merge([
            'customer_delivery_address',
            'customer_billing_address',
            'total_po',
            'total_cost_of_goods',
            'total_tax',
            'total_shipping',
            'gross_profit',
            'gross_profit_percent',
            'grn_status',
            'grn_rate',
            'opf_status',
            'submitted_by',
            'approve_by',
          ]));
        });
    }
};
