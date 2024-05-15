<?php

namespace App\Console\Commands;

use App\Models\EventTable;
use App\Models\Urlcs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\SendTableAsMail;
use Illuminate\Support\Facades\Mail;
use App\Console\Commands\SendEmail;
use App\Models\urlhistory;
use Illuminate\Support\Facades\DB;

class MailTableMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mail-table-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
           
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    //comment of shame
    //public function GetArrays($old, $new){
    //    foreach ($old as $oldUrl) {
    //        $newUrl = $this->findUrlById($new, $oldUrl->id);
    //        $this->info('old = '.$oldUrl);
    //        $this->info('new = '.$newUrl);
    //        if ($oldUrl->status != $newUrl->status) {
    //            // Status has changed, do something
    //            return $this->info("Status changed for URL with ID {$oldUrl->url}");
    //        }
    //    }
    //}
    
    //private function findUrlById($urls, $id) {
    //    foreach ($urls as $url) {
    //        if ($url->id == $id) {
    //            return $url;
    //        }
    //    }
    //    return null;
    //}
    
}
