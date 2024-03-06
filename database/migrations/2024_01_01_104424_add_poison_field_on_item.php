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
        Schema::table('item_invs', function (Blueprint $table) {
            //
          $table->boolean('is_poison')->default('0');
          $table->string('is_poision_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_invs', function (Blueprint $table) {

          $table->dropColumn('is_poison');
          $table->dropColumn('is_poision_note');
            //
        });
    }
};
