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

class MailOnceAday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mail-once-aday';

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
                        if($statusCode == 2){
                            $URLstatus = (' url '.$url->url. ' Status went from '.$url->status.' to '.$status. 'its good now dont worry baby girl ^^');
                            $this->info($URLstatus);
                            Mail::to($sendTo)->send(new SendTableAsMail($URLstatus, $currentDate));
                        }else{
                            return response()->json(['response'=> 'Some of the url went bad']);
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
}
