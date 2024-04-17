<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Urlcs;
use App\Mail\SendTableAsMail;
use App\Models\EventTable;
use Illuminate\Support\Facades\Mail;
class SendMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-monthly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Status Report every month';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        try {

            $data = EventTable::all();
            $firstChar = [];
            $chars = [];
            $four = false;
            $five = false;
            foreach ($data as $url) {
                $char = $url->EventStatusCode;
                $firstChar[] = substr($char, 0,1);
            }
            foreach ($firstChar as $subsrt) {
                    $chars[] = $subsrt;
                    if(5 == $subsrt){
                        //if sent 
                        //five = true
                    }elseif (4 == $subsrt) {
                        //if sent 
                        //four = true
                    }else{
                        return;
                    }
            }

            //$this->info('sending report...');
            //$status = Urlcs::all();
            //$currentDate = date('l, F j, Y');
            //$sendTo = "lagrosaedrian06@gmail.com";
            //$mailMessage = 'Monthly Report - '.$currentDate;
            //Mail::to($sendTo)->send(new SendTableAsMail($status, $currentDate));
            //$this->info('report sent');
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
