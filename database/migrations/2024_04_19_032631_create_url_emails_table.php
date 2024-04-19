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
        
        DB::statement('
        -- recursive loop
        -- after update then update bad move
        CREATE TRIGGER alterSendMailFlag AFTER UPDATE ON urlcs FOR EACH ROW
        BEGIN 
            IF OLD.status <> NEW.status THEN 
                UPDATE urlcs SET sendMailFlag = true WHERE id = OLD.id;
            END IF;
        END;
        -- recursive loop
        ');
        Schema::create('url_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('url_id');
            $table->foreign('url_id')->references('id')->on('urlcs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_emails');
    }
};
