<?php

namespace App\Http\Controllers;

use App\Models\url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProxyController extends Controller
{
    public function getClientDataTree($id) {
        try {
            $urls = DB::table('urls')
                ->where('owner', $id)
                ->pluck('url');
            $urls = DB::table('urls')
                ->where('owner', $id)
                ->pluck('url');
                return response()->json(['url' => $urls]);
            if ($urls->isEmpty()) {
                return response()->json(['error' => 'GTM codes not found for the provided ID'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
