<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\email;
use App\Models\gtmcodes;
use App\Models\url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProxyController extends Controller
{
    public function getClientDataTree($id) {
        try {
            $clientData = clients::select('clients.client', 'urls.url', 'gtmcodes.gtm_codes')
            ->join('urls', 'clients.id', '=', 'urls.owner')
            ->join('gtmcodes', 'urls.id', '=', 'gtmcodes.url')
            ->where('clients.id', $id)
            ->distinct()
            ->get();
            $arrayToStoreLoopedClientsDataBecauseLaravelIsANaggingBitch = [];
            foreach ($clientData as $uniqueData) {
               $arrayToStoreLoopedClientsDataBecauseLaravelIsANaggingBitch[] = $uniqueData;
            }
            return response()->json(['data'=> $arrayToStoreLoopedClientsDataBecauseLaravelIsANaggingBitch]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    
}
