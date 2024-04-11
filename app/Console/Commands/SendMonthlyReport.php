<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Urlcs;
use App\Mail\SendTableAsMail;
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
            $this->info('sending report...');
            $status = Urlcs::all();
            $currentDate = date('l, F j, Y');
            $sendTo = "vlagria3@gmail.com";
            $mailMessage = 'Monthly Report - '.$currentDate;
            Mail::to($sendTo)->send(new SendTableAsMail($status, $currentDate));
            $this->info('report sent');
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
