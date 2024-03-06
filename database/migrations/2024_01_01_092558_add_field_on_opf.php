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
        Schema::table('opf_items', function (Blueprint $table) {
            //
          $table->string('invoice_check')->default(0)->after('gr_number');
          $table->string('invoice_number')->nullable()->after('invoice_check');
          $table->string('do_check')->default(0)->after('invoice_number');
          $table->string('do_number')->nullable()->after('do_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opf_items', function (Blueprint $table) {
            //
          $table->dropColumn(array_merge([
            'do_check',
            'do_number',
            'invoice_check',
            'invoice_number'
            ]));
        });
    }
};
