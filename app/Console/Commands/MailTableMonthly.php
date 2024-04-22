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
        $this->info('Checking url...');
        $this->info(' ');
        $currentDate = date('l, F j, Y');
        try {
            $individualEmail = [];
            $data = Urlcs::all();
            foreach ($data as $url) {
                $status = Http::get($url->url)->status();
                $statusCode = substr($status, 0, 1);
                
                if ($status != $url->status) {
                    $url_emails = DB::table('emails')
                    ->where('url', $url->id)
                    ->pluck('email');
                    $countShit = 0;
                    foreach ($url_emails as $singleMail) {
                        $countShit++;
                        $sendTo = $singleMail;
                        Urlcs::where('id', $url->id)->update(['status' => $status]);
                        if($statusCode == 4 || $statusCode == 5){
                            $URLstatus = (' url '.$url->url. ' Emails '. $singleMail. ' status '.$status);
                            //$this->info("notify client with this client error = {$url->url} = {$status} emails {$singleMail}");
                            Mail::to($sendTo)->send(new SendTableAsMail($URLstatus, $currentDate));
                            
                        }else{
                           $this->info('we good for now my g');
                        }
                    }
                }
            }
            $this->info($countShit);
            $this->info(' ');
            $this->info('Command finish');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    //commented out of shame
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
