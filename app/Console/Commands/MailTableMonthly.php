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
        $this->info('Command running...');
        try {
            $data = Urlcs::all();
            foreach($data as $urls){
                $url = $urls->url;
                //$this->info('heres the url'. $urls);
                $stat = Http::get($url);
                $code = $stat->status($stat);
                $id = $urls->id;
                $this->info($id . ' ' . $code . ' ' . $url);
                Urlcs::where('id', $id)->update(['status' => $code]);
            }
            $this->info('Command finish');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
