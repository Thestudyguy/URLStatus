<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Emails;
use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NewClientController extends Controller
{
    public function SaveNewClient(Request $request){

        $client = $request->client;
        $client_email = $request->client_email;
        $client_contact = $request->client_contact;
        $email_array = $request->email;
        $url_array = $request->url;
        
        $url = [];
        $email = [];
        $gtm_codes = [];
        $status = '';
        Log::info($client);
        Log::info($client_email);
        Log::info($client_contact);
        //foreach ($email_array as $emails) {
        //    //Log::info($emails);
        //    $notify_email = $email[] = $emails;
        //    Log::info($notify_email);
        //}
        foreach ($url_array as $urls) {
            $pattern = '/googletagmanager\.com\/gtm\.js\?id=([^\s"\'<]+)/i';
            $patternGTM = '/GTM-([a-zA-Z0-9]+)/i';
            $singularUrl = $url[] = $urls;
            $response = Http::get($singularUrl);
            $status = $response->status();
            $body = $response->body();
            $gtmcode = [];
            preg_match_all($patternGTM, $body, $matches);
            foreach ($matches as $gtm) {
               $code = $gtmcode[] = $gtm;
               Log::info($code);    
            }
            Log::info('URL = '. $singularUrl. ' status = '. $status);
        }

    }
}
/**
 * MediaOne PH
 * MediaOnePH.business@gmail.com
 * 09123456789
 *  https://agupubs.onlinelibrary.wiley.com/doi/abs/10.1029/2020EA001602
 *  https://www.pemavor.com/solution/keyword-grouping-tool/
 *  www.spyserp.com/keyword-grouping
 *  https://www.pingshiuanchua.com/tools/keyword-clustering/
 *  https://chrome.google.com/webstore/detail/keyword-extractor/hgdanalmcipcgojcicjenedeaoedebla?hl=en
 * 
 * 
 * 
 * 
 */