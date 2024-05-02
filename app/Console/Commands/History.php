<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendTableAsMail;
use App\Console\Commands\SendEmail;
use Illuminate\Support\Facades\Http;
use App\Models\Urlcs;
use App\Models\urlhistory;

class History extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:history';

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
        //$this->info('Checking url...');
        //$this->info(' ');
        //$currentDate = date('l, F j, Y');
        //try {
        //    $data = Urlcs::all();
        //    foreach ($data as $url) {
        //        $status = Http::get($url->url)->status();
        //        if ($url->status != $status) {
        //            $this->info(' url '.$url->url. ' old stat '. $url->status. ' new stat '. $status);
        //            urlhistory::create([
        //                'url' => $url->url,
        //                'old_status' =>$url->status,
        //                'new_status' =>$status,
        //                'url_ref' => $url->id
        //            ]);
        //        }else{
        //            $this->info("No url change status ". $currentDate);
        //        }
        //    }
        //    $this->info(' ');
        //    $this->info('Command finish');
        //} catch (\Throwable $th) {
        //    throw $th;
        //}
    }
}
