<?php

namespace App\Http\Controllers;

use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\SendTableAsMail;
use App\Models\EventTable;
use App\Models\MailModel;
use App\Models\UrlEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class URLController extends Controller
{

    public function storeEmailandURL(Request $request){
            $email = [];
            $url = $request->url;
            $emails = $request->email;
            $response = Http::get($url);
            $status = '404';//$response->status();
            foreach ($emails as $mail) {
                $email[] = $mail;
            }
            $isURLExisting = Urlcs::where('url', $url)->first();
            if(!$isURLExisting){
                $uid = Urlcs::create([
                    'url' => $url,
                    'status' => $status
                ]);
                $url_id = $uid->id;
                Log::info($email);

                foreach ($email as $singleEmail) {
                    UrlEmail::create([
                        'email' => $singleEmail,
                        'url_id' => $url_id
                    ]);
                }

                return response()->json(['response' => $url, 'status' => $status, 'proxyID' => $uid, 'email' => $email], 200);
            }else {
                return response()->json(['isExisting' => 'url already exists', 'status' => $status]);
            }
    }


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
        try {
                return response()->json(['body' => $body, 'response' => $url, 'status' => $status], 200);
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
        if($status == $status){
            Mail::to($sendTo)->send(new SendTableAsMail($status, $currentDate));
            return response()->json(['respond' => 'its working']);
        }
    }
    

    public function GetEmail(Request $request){

    }
}
