<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\email;
use App\Models\Emails;
use App\Models\gtmcodes;
use App\Models\url;
use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NewClientController extends Controller
{
    public function SaveNewClient(Request $request){
        try {
        $client = $request->client;
        $client_email = $request->client_email;
        $client_contact = $request->client_contact;
        $urls = $request->url;
        $email = $request->email;
        $client_saved = Clients::create([
            'client' => $client,
            'email' => $client_email,
            'contact' => $client_contact,
        ]);
        $client_id = $client_saved->id;
        $this->saveUrl($client_id, $urls, $email);
        $this->saveClientEmails($client_id, $email);
        //Log::info($client_id);
        //Log::info($urls);
        //Log::info($email);
        return response()->json(['success' => 'Client added successfuly', 'id' => $client_id]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th]);
        }
    }
    private function saveUrl($clientID, $urls, $emails){
        try {
            $gtm_codes = [];
            $gtm_serial_number_pattern = '/GTM-([a-zA-Z0-9]+)/i';
            foreach ($urls as $url) {
                $response = Http::get($url);
                $status = $response->status();
                $body = $response->body();
                preg_match_all($gtm_serial_number_pattern, $body, $matches);
                $saved_url = url::create([
                    'url' => $url,
                    'status' => $status,
                    'owner' => $clientID
                ]);
            }
            $url_id = $saved_url->id;
            if (!empty($matches[1])) {
                $unique_gtm = $gtm_codes[] = $matches[1];
                $gtm = array_unique($unique_gtm);
                $this->saveGtmCodes($url_id, $gtm);
            }
            Log::info($saved_url);
            return response()->json(['success' => 'URLs added successfully']);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => 'Failed to add URLs'], 500);
        }
    }
    private function saveGtmCodes($UrlID, $gtm_codes){
        try {
            foreach ($gtm_codes as $gtm) {
                $gtmcodes = $gtm;
                gtmcodes::create([
                    'gtm_codes' => $gtmcodes,
                    'url' => $UrlID
                ]);
            }
            return response()->json(['success' => 'GTM Codes added successfully']);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => 'Failed to add GTM Codes'], 500);
        }
    }
    private function saveClientEmails($clientID, $emails){
        try {
            foreach ($emails as $email) {
                email::create([
                    'email' => $email,
                    'client' => $clientID 
                ]);
            }
            return response()->json(['success' => 'Failed to add Emails']);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => 'Failed to add Emails'], 500);
        }

    }
    public function getClients(){
        try {
            $clients = Clients::all();
            return view('components.Card', compact('clients'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function default(){
        try {
            $clients = Clients::all();
            return view('index', compact('clients'));
        } catch (\Throwable $th) {
            throw $th;
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