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
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

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
    protected $description = 'Fetches URLs, checks their status, and sends email notifications if status has changed.';


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
            $body = $response->body();
            preg_match_all('/GTM-([a-zA-Z0-9]+)/i', $body, $matches);
            $gtmCodes = array_unique($matches[0]);
            $existingGtmCodes = gtmcodes::whereIn('gtm_codes', $gtmCodes)->pluck('gtm_codes')->toArray();
            $newGtmCodes = array_diff($gtmCodes, $existingGtmCodes);
            foreach ($newGtmCodes as $code) {
                gtmcodes::create([
                    'gtm_codes' => $code,
                    'url' => $url->id,
                ]);
            }
            $clientEmails = array_filter($clients, function ($client) use ($url) {
                return $client['client'] === $url->owner;
            });
            $clientEmails = array_column($clientEmails, 'email');
            foreach ($clientEmails as $email) {
                if ($status != $url->status) {
                    try {
                        Mail::to($email)->send(new SendTableAsMail($status, $currentDate, $url->url, $url->status));
                        $this->info("Email sent to $email successfully. handle()");
                    } catch (\Exception $e) {
                        $this->error("Error sending email to $email: " . $e->getMessage());
                    }
                }
            }
        }
        $this->UpdateURLAndGTMCcodes($urls);
        $this->info('cron job ended');
    } catch (\Throwable $th) {
        throw $th;
    }
}

    public function UpdateURLAndGTMCcodes($urls)
    {
        try {
            foreach ($urls as $url) {
                $response = Http::get($url->url);
                $status = $response->status();
                if($status != $url->status){
                    $this->info("URL = $url->url old status = $url->status new status = $status UpdateURLAndGTMCodes()");
                    urlhistory::create([
                        'url' => $url->url,
                        'status' => $status,
                        'old_status' => $url->status,
                        'new_status' => $status,
                        'url_id' => $url->id
                    ]);
                }
                $url->status = $status;
                $url->save();
            }
        } catch (\Throwable $th) {
                throw $th;
        }
    }

}
