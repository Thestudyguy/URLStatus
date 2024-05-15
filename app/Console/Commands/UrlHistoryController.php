<?php

namespace App\Console\Commands;

use App\Models\gtmcodes;
use App\Models\url;
use App\Models\urlhistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\clients;
use App\Console\Commands\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendTableAsMail;
use App\Models\email;

class UrlHistoryController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:url-history-controller';

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
            $this->info('Starting the cron job');
            $urls = url::all();
            $clients = email::select('client', 'email')->distinct()->get()->toArray();
            $currentDate = date("F j Y");
            foreach ($urls as $url) {
                $response = Http::get($url->url);
                $status = $response->status();
                $clientEmails = array_filter($clients, function ($client) use ($url) {
                    return $client['client'] === $url->owner;
                });
                $clientEmails = array_column($clientEmails, 'email');
                foreach ($clientEmails as $email) {
                    if ($status != $url->status) {
                        
                        $this->info("URL = $url->url, current status = $url->status, new status = $status, recipient = $email");
                        Mail::to($email)->send(new SendTableAsMail($status, $currentDate, $url->url, $url->status));
                    }
                }
            }
            $this->info('cron job ended');
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
