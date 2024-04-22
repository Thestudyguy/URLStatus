<?php

namespace App\Http\Controllers;

use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\SendTableAsMail;
use App\Models\Emails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class URLController extends Controller
{

    public function storeEmailandURL(Request $request){
            $email = [];
            $url = $request->url;
            $emails = $request->email;
            $response = Http::get($url);
            $status = $response->status();
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
                    Emails::create([
                        'email' => $singleEmail,
                        'url' => $url_id
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
    //public function sendMonthlyReport()
    //{
    //   // $this->info('Checking url...');
    //    //$this->info(' ');
    //    $currentDate = date('l, F j, Y');
    //    try {
    //        $individualEmail = [];
    //        $data = Urlcs::all();
    //        foreach ($data as $url) {
    //            $status = Http::get($url->url)->status();
    //            $statusCode = substr($status, 0, 1);
    //            
    //            if ($status != $url->status) {
    //                $url_emails = DB::table('emails')
    //                ->where('url', $url->id)
    //                ->pluck('email');
    //                foreach ($url_emails as $singleMail) {
    //                    $sendTo = $singleMail;
    //                    Urlcs::where('id', $url->id)->update(['status' => $status]);
    //                    if($statusCode == 4 || $statusCode == 5){
    //                        $URLstatus = (' url '.$url->url. ' Status went from '.$url->status.' to '.$status);
    //                        //$this->info("notify client with this client error = {$url->url} = {$status} emails {$singleMail}");
    //                        Mail::to($sendTo)->send(new SendTableAsMail($URLstatus, $currentDate));
    //                        return response()->json(['response'=>'working']);
    //                    }else{
    //                       //$this->info('we good for now my g');
    //                    }
    //                }
    //            }
    //        }
    //        //$this->info(' ');
    //        //$this->info('Command finish');
    //    } catch (\Throwable $th) {
    //        throw $th;
    //    }
    //}
    

    public function GetEmail($id){
        $singleMail = [];
        try {
            $url_emails = DB::table('emails')
            ->where('url', $id)
            ->pluck('email');
            foreach ($url_emails as $email) {
                $singleMail[] = $email;
            }
            if(empty($url_emails)){
                return response()->json(['response'=> 'No email associated with selected url']);
            }
            Log::info($singleMail);
            return response()->json(['res' => $singleMail]);
        } catch (\Throwable $th) {
            throw new $th;
        }
    }
}
