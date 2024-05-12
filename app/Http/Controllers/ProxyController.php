<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\email;
use App\Models\url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProxyController extends Controller
{
    public function getClientDataTree($id) {
        try {
            $client_details_url = DB::table('urls')->where('owner', $id)->get();
            $client_details_email = DB::table('emails')->where('client', $id)->get();
            $url_codes = DB::table('gtmcodes')->where('url', $id)->get();

            return response()->json(['email' => $client_details_email, 'url' => $client_details_url, 'codes' => $url_codes]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
}
