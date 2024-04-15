<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
       CREATE TRIGGER insert_changes AFTER UPDATE ON urlcs FOR EACH ROW
       BEGIN 
       IF old.status <> new.status THEN 
       INSERT INTO event_tables(EventStatusCode, EventURL) VALUES (new.status, old.url);
       END IF;
       END ;
       ');
       Schema::table('event_tables', function(Blueprint $table){
        $table->boolean('piece_is_sent')->default(false)->after('EventStatusCode');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER insert_changes');
        Schema::table('event_tables', function(Blueprint $table){
            $table->dropColumn('piece_is_sent');
        }); 
    }
};
