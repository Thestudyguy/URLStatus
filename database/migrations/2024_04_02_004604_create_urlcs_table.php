<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('urlcs', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('status');
            $table->boolean('IsVisible')->default(true);
            $table->unsignedBigInteger('owner');
            $table->foreign('owner')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urlcs');
    }
};
