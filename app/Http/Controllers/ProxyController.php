<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\email;
use App\Models\gtmcodes;
use App\Models\url;
use App\Models\urlhistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProxyController extends Controller
{
    public function getClientDataTree($id) {
        try {
            $clientData = client::select('clients.client', 'urls.url', 'urls.status', 'gtmcodes.gtm_codes')
            ->join('urls', 'clients.id', '=', 'urls.owner')
            ->Leftjoin('gtmcodes', 'urls.id', '=', 'gtmcodes.url')//->join('gtmcodes', 'urls.id', '=', 'gtmcodes.url') sa join diay ko na dale kay di man diay mo return ning amaw 
                                                                  //ug url ug walay associated data sa gi join na table 
                                                                  //if i want it otherwise i would have to use left join 
                                                                  //to include the urls without gtmcodes in the gtmcodes table
            ->where('clients.id', $id)
            ->distinct()
            ->get();
            return response()->json(['data'=>$clientData]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function getAll(){
        try {
            $clientData = client::select('clients.client', 'urls.url', 'urls.status', 'gtmcodes.gtm_codes')
            ->join('urls', 'clients.id', '=', 'urls.owner')
            ->leftJoin('gtmcodes', 'urls.id', '=', 'gtmcodes.url')
            ->distinct()
            ->get();
            return response()->json([
                'data' => $clientData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getURLHistory()
    {
        $ladyBoy = DB::table('clients')
            ->join('urls', 'clients.id', '=', 'urls.owner')
            ->join('urlhistories', 'urls.id', '=', 'urlhistories.url_id')
            ->select('clients.client', 'clients.id as client_id', 'urls.id', 'urls.url', 'urls.owner', 'urlhistories.old_status', 'urlhistories.created_at')
            ->distinct()
            ->get()
            ->groupBy('client_id');
        return view('pages.url', compact('ladyBoy'));
    }
}
