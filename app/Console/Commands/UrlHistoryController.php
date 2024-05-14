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
        $urls = Url::all();
    
        foreach ($urls as $url) {
            $urlId = $url->id;
            $status = $url->status;
            $emails = email::where('client', $url->owner)->pluck('email');
            Mail::to($emails)->send(new SendTableAsMail($status, $urlId));
            if ($emails->isNotEmpty()) {
                $this->info("Emails associated with URL (ID: $urlId): " . implode(', ', $emails->toArray()));
            } else {
                $this->info("No emails found for URL (ID: $urlId)");
            }
        }
    
        $this->info('Finish');
    }
    

    public function getGTM($gtmcodes){

    }
}
