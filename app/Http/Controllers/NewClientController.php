<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Emails;
use App\Models\gtmcodes;
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
            'contact_number' => $client_contact,
        ]);
        $client_id = $client_saved->id;
        $this->saveUrl($client_id, $urls, $email);
        return response()->json(['success' => 'Client added successfuly', 'id' => $client_id]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th]);
        }
    }
    private function saveUrl($clientID, $urls, $emails){
        try {
            $client_id = $clientID;
            $gtm_codes = [];
            $gtm_serial_number_pattern = '/GTM-([a-zA-Z0-9]+)/i';
            foreach ($urls as $url) {
                if(!empty($url)){
                    $singularUrl = $url;
                    $response = Http::get($singularUrl);
                    $status = $response->status();
                    $body = $response->body();
                    preg_match_all($gtm_serial_number_pattern, $body, $matches);
                    $url_id = Urlcs::create([
                        'url' => $singularUrl,
                        'status' => $status,
                        'owner' => $clientID,
                    ]);
                    $url_foreign_id = $url_id->id;
                    if (!empty($matches[1])) {
                        $unique_gtm = $gtm_codes[] = $matches[1];
                        $gtm = array_unique($unique_gtm);
                        $this->saveGtmCodes($url_foreign_id, $gtm);
                    }
                }
                $this->saveClientEmails($clientID, $url_foreign_id, $emails);
            }
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
    private function saveClientEmails($clientID, $UrlID, $emails){
        try {
            Log::info('Client = '.$clientID. ' URL = '. $UrlID. 'Email = '. $emails);
            foreach ($emails as $email) {
                Emails::create([
                    'email' => $email,
                    'url' => $UrlID,
                    'client' => $clientID 
                ]);
                return response()->json(['success' => 'Failed to add Emails']);
        }
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