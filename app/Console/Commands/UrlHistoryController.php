<?php

namespace App\Console\Commands;

use App\Models\gtmcodes;
use App\Models\url;
use App\Models\urlhistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $urls = url::all();
        foreach ($urls as $url) {
                //$this->info($url->status);
                $response = Http::get($url->url);
                $status = $response->status();
                $body = $response->body();
                $gtmcodes = [];
                preg_match_all('/GTM-([a-zA-Z0-9]+)/i', $body, $matches);
                foreach ($matches[0] as $gtm) {
                    $gtmcodes[] = $gtm;
                }
                $uniqueArray = array_unique($gtmcodes);
                if($status != $url->status){
                    $this->info($status. ' = '. $url->url. ' notify authorities now! ~nya oni-chan');
                    
                }else{
                    $this->info('were fine. We are okay!');
                }
                //$this->getGTM($uniqueArray);
                //$this->info('start here...');                
                //$this->info($url);
                //$this->info($status);
                //$this->info(implode(', ', $uniqueArray));
                //$this->info('end here...');                
        }
        $this->info('finish');
    }

    public function getGTM($gtmcodes){

    }
}
