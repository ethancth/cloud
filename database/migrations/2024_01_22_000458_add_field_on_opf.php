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
          $table->string('created_by');
          $table->dateTime('submited_at')->nullable();
          $table->dateTime('approve_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opfs', function (Blueprint $table) {
            //
          $table->dropColumn('created_by');
          $table->dropColumn('submited_at');
          $table->dropColumn('approve_at');
        });
    }
};
