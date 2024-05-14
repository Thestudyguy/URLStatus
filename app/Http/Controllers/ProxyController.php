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
            $clientData = clients::select('clients.client', 'urls.url', 'urls.status', 'gtmcodes.gtm_codes')
            ->join('urls', 'clients.id', '=', 'urls.owner')
            ->Leftjoin('gtmcodes', 'urls.id', '=', 'gtmcodes.url')//->join('gtmcodes', 'urls.id', '=', 'gtmcodes.url') sa diay ko na dale kay di man diay mo return ning amaw 
                                                                  //ug url ug walay associated data sa gi join na table 
                                                                  //if i want it otherwise i would have to use left join 
                                                                  //to include the urls without gtmcodes in the gtmcodes table
            ->where('clients.id', $id)
            ->distinct()
            ->get();
            //$arrayToStoreLoopedClientsDataBecauseLaravelIsANaggingBitch = [];
            //foreach ($clientData as $uniqueData) {
            //   $arrayToStoreLoopedClientsDataBecauseLaravelIsANaggingBitch[] = $uniqueData;
            //}
            return response()->json(['data'=>$clientData]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    
}
