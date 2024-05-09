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
        Schema::create('gtmcodes', function (Blueprint $table) {
            $table->id();
            $table->string('gtm_codes');
            $table->unsignedBigInteger('url');
            $table->foreign('url')->references('id')->on('urls')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtmcodes');
    }
};
