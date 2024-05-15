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
                $clientEmails = array_filter($clients, function ($client) use ($url) {
                    return $client['client'] === $url->owner;
                });
                $clientEmails = array_column($clientEmails, 'email');
                foreach ($clientEmails as $email) {
                    if ($status != $url->status) {
                        $this->info("URL = $url->url, current status = $url->status, new status = $status, recipient = $email");
                        try {
                            Mail::to($email)->send(new SendTableAsMail($status, $currentDate, $url->url, $url->status));
                            $this->info("Email sent to $email successfully.");
                        } catch (\Exception $e) {
                            $this->error("Error sending email to $email: " . $e->getMessage());
                        }
                        //create a seperate method that updates the url status after all the recipient is notified
                        //urlhistory::create([
                        //    'url' => $url->url,
                        //    'status' => $status,
                        //    'old_status' => $url->status,
                        //    'new_status' => $status,
                        //    'url_id' => $url->id
                        //]);
                        //$url->status = $status;
                        //$url->save();
                        //updating the url status simoultaneously notifying the recipient will not work as expected
                    }
                }
            }
            $this->info('cron job ended');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function UpdateURLAndGTMCcodes()
    {
        try {
            $urls = Url::all();
            foreach ($urls as $url) {
                $response = Http::get($url->url);
                $status = $response->status();
                $body = $response->body();
                preg_match_all('/GTM-([a-zA-Z0-9]+)/i', $body, $matches);
                if($status != $url->status){
                    $this->info("URL = $url old status = $url->status new status = $status");
                    urlhistory::create([
                        'url' => $url->url,
                        'status' => $status,
                        'old_status' => $url->status,
                        'new_status' => $status,
                        'url_id' => $url->id
                    ]);
                }
                // Extract GTM codes from the matches
                $gtmCodes = [];
                foreach ($matches[1] as $match) {
                    $gtmCodes[] = $match;
                }

                // Update URL status and GTM codes
                $url->status = $status;
                $url->gtm_codes = json_encode($gtmCodes); // Store GTM codes as JSON
                $url->save();
            }
        } catch (\Throwable $th) {
            // Handle the exception as needed
        }
    }

}
