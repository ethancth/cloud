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
        Schema::table('users', function (Blueprint $table) {

          $table->string('division_id')
            ->after('password')
            ->nullable();
          $table->string('division_name')
            ->after('division_id')
            ->nullable();
          $table->string('contact')
            ->after('division_name')
            ->nullable();
          $table->string('position_id')
            ->after('contact')
            ->nullable();
          $table->string('position_name')
            ->after('position_id')
            ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn(array_merge([
            'division_id',
            'division_name',
            'contact',
            'position_id',
            'position_name',
          ]));
        });
    }
};
