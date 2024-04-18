<?php

namespace App\Console\Commands;

use App\Models\EventTable;
use App\Models\Urlcs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\SendTableAsMail;
use Illuminate\Support\Facades\Mail;

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
        $this->info('Checking urls...');
        try {
            $data = Urlcs::all();
            foreach($data as $urls){
                $url = $urls->url;
                //$this->info('heres the url'. $urls);
                $stat = Http::get($url);
                $code = $stat->status($stat);
                $id = $urls->id;
                //$this->info($id . ' ' . $code . ' ' . $url);
                Urlcs::where('id', $id)->update(['status' => $code]);
            }
            $event = EventTable::where('piece_is_sent', false)->get();
            
            foreach ($event as $mail) {
            $currentDate = date('l, F j, Y');
            $sendTo = "lagrosaedrian06@gmail.com";
            //$mailMessage = 'Monthly Report - ' . $currentDate;
            //Mail::to($sendTo)->send(new SendTableAsMail($mail, $currentDate));
                $eventURL = $mail->EventURL;
                $eventStat = $mail->EventStatusCode;
                $eventPIS = $mail->piece_is_sent;
                $this->info($eventStat . ' ' . $eventURL . ' '. $eventPIS);
                if($eventPIS == 0){
                    Mail::to($sendTo)->send(new SendTableAsMail($mail, $currentDate));
                }else{
                    break;
                }
            }
            
            $this->info('Command finish');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
