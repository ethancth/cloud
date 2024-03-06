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
        Schema::create('opf_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('download_url');
            $table->string('upload_by');
            $table->string('opf_id')->index();
            $table->string('file_size');
            $table->boolean('status')->default('1');
            $table->integer('download_count')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opf_uploads');
    }
};