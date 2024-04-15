<?php

namespace App\Http\Controllers;

use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\SendTableAsMail;
use App\Models\EventTable;
use Illuminate\Support\Facades\Mail;

class URLController extends Controller
{


    public function getURL()
    {
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
        Log::info($headers);
        Log::info($status);
        try {
            if (empty($url)) {
                return response()->json(['url is empty'], 500);
            }
            $isURLExisting = Urlcs::where('url', $url)->first();
            if (!$isURLExisting) {
                $uid = Urlcs::create([
                    'url' => $url,
                    'status' => $status
                ]);
                return response()->json(['body' => $body, 'response' => $url, 'status' => $status, 'proxyID' => $uid], 200);
            } else {
                return response()->json(['isExisting' => 'url already exists', 'headers' => $headers, 'status' => $status]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function listURL()
    {
        try {
            $lists =  Urlcs::all();
            return view('table', compact('lists'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
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
    public function removeUrlfromList(Request $request)
    {
        try {
            $id = $request->id;
            Urlcs::where('id', $id)->update(['isVisible' => false]);
            return response()->json([
                'response' => 'it okay',
                200
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th]);
        }
    }
    public function FilterStatus(Request $request)
    {
        $status = $request->status;
        try {
            $urlStatus = Urlcs::where('status', 'like', "%$status%")->where('IsVisible', true)->get();
            return response()->json(['response' => $urlStatus], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    //update piece_is_sent = 1 if sent
    // 4 || 5 && piece_is_sent = 0
    //optional 
    //1 || 2 || 3 && piece_is_sent = 0 
    //set daily
    public function mailDailyChanges()
    {
        $changes = EventTable::all();
        $sentStatus = EventTable::where('piece_is_sent', 0)->pluck('piece_is_sent');
        if (count($changes) > 0) {
            Log::info(count($changes));
            Log::info('table has bit data init');
            Log::info($changes);
            Log::info(count($sentStatus));
        } else {
            Log::info('table has no bit data init');
            Log::info($changes);
        }
    }

    public function getStatusandPIS()
    {
        $four = 4;
        $five = 5;
        $data = EventTable::pluck('EventStatusCode');
        $getData = EventTable::all();
        
        //kana na loop
        //Log::info($column1Values);
        /**
         * $column1Values = [];
        $column2Values = [];
        $okok = [];
//kani na loop
        foreach ($getData as $row) {
            $column1Values[] = $row->EventStatusCode;
            //$column1Values[] = $row->EventURL;
            //Log::info($getData);
        }
        foreach ($column1Values as $stuff) {
            $okok[] = $stuff; 
            $column2Values[] = substr($stuff, 0, 1);
            Log::info($column2Values);
            if($five == $column2Values || $four == $column2Values){
                Log::info('match ' . $stuff . ' = ' . $five . '');
            }else{
                Log::info('not match ' . $stuff . ' = ' . $five . '');
            }
        }
         * 
         */
        $firstChar = [];
        $alChar = [];
        Log::info('start');
        foreach ($getData as $statChar) {
            $firtCharStuff = $statChar->EventStatusCode;
            $firstChar[] = substr($firtCharStuff, 0, 1);
        }
        foreach ($firstChar as $char) {
            $alChar[] = $char;
            if ($five == $char || $four == $char) {
                Log::info('match ' . $char . ' = ' . $five . ' '. $statChar->EventURL);
                Log::info('imagine this is a method to call when we met the criteria');
            } else {
                Log::info('not match ' . $char . ' = ' . $five . '');
            }
        }
        Log::info($alChar);
        Log::info('end');
    }

    public function getStatus()
    {
        try {
            $status = Urlcs::pluck('status')->unique();
            $first =  substr($status, 0, 1);
            Log::info($first);
            return response()->json(['status' => $status, 'asd' => $first]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function sendMonthlyReport()
    {
        $status = Urlcs::all();
        $currentDate = date('l, F j, Y');
        $sendTo = "lagrosaedrian06@gmail.com";
        $mailMessage = 'Monthly Report - ' . $currentDate;
        Mail::to($sendTo)->send(new SendTableAsMail($status, $currentDate));
    }
}
