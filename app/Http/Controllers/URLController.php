<?php

namespace App\Http\Controllers;

use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class URLController extends Controller
{
    public function getURL(){
        try {
            $lists =  Urlcs::all();
            return view('index', compact('lists'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function GetURLHeaders(Request $request)
    {
        $url = $request->url;   
        $response = Http::get($url);
        $status = $response->status();
        $body = $response->body();
        $headers = $response->headers();
        try {
            if(empty($url)){
                return response()->json(['url is empty'], 500);
            }
            $isURLExisting = Urlcs::where('url', $url)->first();
            if(!$isURLExisting){
                $uid = Urlcs::create([
                'url' => $url,
                'status' => $status
            ]);
            return response()->json(['body'=>$body, 'response' => $url, 'status' => $status, 'proxyID' => $uid], 200);
            }else{
                return response()->json(['isExisting'=> 'url already exists', 'headers'=>$headers, 'status' => $status]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function listURL(){
        try {
            $lists =  Urlcs::all();
            return view('table', compact('lists'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request) {
        try {
            $search = $request->search;
            Log::info($search);
            if (!empty($search)) {
                $url = Urlcs::where('url', 'like', "%$search%")->get();
            } else {
                $url = Urlcs::all();
            }
    
            return response()->json(['data' => $url]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function removeUrlfromList(Request $request){
        try {
            $id = $request->id;
            Urlcs::where('id', $id)->update(['isVisible' => false]);
            return response()->json([
                'response' => 'it okay', 
                200
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th]);
        }
    }
    public function FilterStatus(Request $request){
        $status = $request->status;
        try {
            $urlStatus = Urlcs::where('status', 'like', "%$status%")->get();
            return response()->json(['response'=>$urlStatus], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
