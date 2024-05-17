<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\email;
use App\Models\gtmcodes;
use App\Models\url;
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
        $emails = $request->email;
        $client_saved = clients::create([
            'client' => $client,
            'email' => $client_email,
            'contact' => $client_contact,
        ]);
        $client_id = $client_saved->id;
        $this->saveGTMandURL($urls, $client_id);
        //saving email
        foreach ($emails as $email) {
            email::create([
                'email' => $email,
                'client' => $client_id
            ]);
        }
        return response()->json(['success' => 'Client added successfuly', 'id' => $client_id]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th]);
        }
    }
    
    private function saveGTMandURL($urls, $owner){
        try {
            foreach ($urls as $url) {
                $response = Http::get($url);
                $status = $response->status();
                $body = $response->body();
                preg_match_all('/GTM-([a-zA-Z0-9]+)/i', $body, $matches);
    
                $urlObject = Url::create([
                    'url' => $url,
                    'status' => $status,
                    'owner' => $owner
                ]);
    
                $urlId = $urlObject->id;
                $uniqueGTM = array_unique($matches[0]);
                foreach ($uniqueGTM  as $gtmCode) {
                    Gtmcodes::create([
                        'gtm_codes' => $gtmCode,
                        'url' => $urlId
                    ]);
                }
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }
    //okay na diri from saveGTMadnURL to saveNewClient
    public function getClients(){
        try {
            $clients = clients::all();
            return $clients;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function default(){
        try {
            $clients = clients::all();
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