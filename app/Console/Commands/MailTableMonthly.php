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
                        $sendTo = $singleMail;
                        Urlcs::where('id', $url->id)->update(['status' => $status]);
                        if($statusCode == 4 || $statusCode == 5){
                            $URLstatus = (' url '.$url->url. ' Status went from '.$url->status.' to '.$status);
                            Mail::to($sendTo)->send(new SendTableAsMail($URLstatus, $currentDate));
                            if ($url->status != $status) {
                                $this->info(' url '.$url->url. ' old stat '. $url->status. ' new stat '. $status);
                                urlhistory::create([
                                    'url' => $url->url,
                                    'old_status' =>$url->status,
                                    'new_status' =>$status,
                                    'url_ref' => $url->id
                                ]);
                            }else{
                                $this->info("No url change status ". $currentDate);
                            }
                        }else{
                           $this->info('we good for now my g');
                        }
                    }
                }
            }
            $this->info(' ');
            $this->info('Command finish');
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
