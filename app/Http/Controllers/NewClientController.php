<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\email;
use App\Models\gtmcodes;
use App\Models\url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $client_saved = client::create([
            'client' => $client,
            'email' => $client_email,
            'contact' => $client_contact,
        ]);
        $client_id = $client_saved->id;
        $client_name = $client_saved->client;
        $this->saveGTMandURL($urls, $client_id);
        //saving email
        foreach ($emails as $email) {
            email::create([
                'email' => $email,
                'client' => $client_id
            ]);
        }
        return response()->json(['success' => 'Client added successfuly', 'id' => $client_id, 'client' => $client_name]);
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
            $clients = client::latest()->first();
            return $clients;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getAllClients(){
        try {
            $clients = client::latest();
            return $clients;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function defaultPage(){
        try {
            $clients = client::all();
            return view('index', compact('clients'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
