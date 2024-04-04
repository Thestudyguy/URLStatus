<?php

namespace App\Console\Commands;

use App\Models\Urlcs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $data = Urlcs::all();
            foreach($data as $urls){
                $this->info('heres the url'. $urls);
                //Log::info('heres the url'. $urls);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
