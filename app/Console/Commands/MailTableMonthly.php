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
                $stat = Http::get($url);
                $code = $stat->status($stat);
                $id = $urls->id;
                $statChar = $code;
                $firstStatChar = substr($statChar, 0, 1);
                Urlcs::where('id', $id)->update(['status' => $code]);
            }
            $this->info('Command finish');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
