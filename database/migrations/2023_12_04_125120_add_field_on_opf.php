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
          $table->string('currency')->nullable();
          $table->string('currency_rate')->nullable();
          $table->string('pic_id')->nullable();
          $table->string('pic_name')->nullable();
          $table->string('pic_email')->nullable();
          $table->string('contact')->nullable();
          $table->string('sales_person_id')->after('sales_person')->nullable();
          $table->string('tags')->nullable();
          $table->string('notes')->nullable();
          $table->string('slug')->nullable();
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
            'currency',
            'currency_rate',
            'pic_id',
            'pic_name',
            'pic_email',
            'contact',
            'sales_person_id',
            'notes',
            'tags',
            'slug',
          ]));
        });
    }
};
