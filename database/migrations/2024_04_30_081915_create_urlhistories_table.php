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
        Schema::create('urlhistories', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('old_status');
            $table->string('new_status');
            $table->unsignedBigInteger('url_ref');
            $table->foreign('url_ref')->references('id')->on('urlcs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urlhistories');
    }
};
