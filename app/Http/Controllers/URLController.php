<?php

namespace App\Http\Controllers;

use App\Models\Urlcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\SendTableAsMail;
use App\Models\Clients;
use App\Models\Emails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class URLController extends Controller
{
    public function logIn(){
        return view('auth.login');
    }

    public function storeEmailandURL(Request $request)
{
    try {
        $email = [];
        $url = $request->url;
        $emails = $request->email;
        $response = Http::get($url);
        $status = $response->status();

        $isURLExisting = Urlcs::where('url', $url)->first();
        if (!$isURLExisting) {
            $urlRecord = Urlcs::create([
                'url' => $url,
                'status' => $status
            ]);
            $url_id = $urlRecord->id;
            foreach ($emails as $singleEmail) {
                Emails::create([
                    'email' => $singleEmail,
                    'url' => $url_id
                ]);
            }
            $statChar = substr($status, 0, 1);
            return response()->json(['response' => "request finished", 'status' => $status, 'url' => $url, 'character' => $statChar]);
        } else {
            return response()->json(['error' => 'URL already exists'], 409);
        }
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
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
            return response()->json(['status' => $status, 'asd' => $first]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function GetEmail($id)
    {
        $singleMail = [];
        try {
            $url_emails = DB::table('emails')
                ->where('url', $id)
                ->pluck('email');
            foreach ($url_emails as $email) {
                $singleMail[] = $email;
            }
            if (empty($url_emails)) {
                return response()->json(['response' => 'No email associated with selected url']);
            }
            return response()->json(['res' => $singleMail]);
        } catch (\Throwable $th) {
            throw new $th;
        }
    }
    public function register(){
        return view('auth.register');
    }
    public function RegisterUser(Request $request){
        try {
            $request->validate([
                "fname" => "required",
                "lname" => "required",
                "email" => "required|email|unique:users",
                "password"=> "required",
                "isUserPrivileged"=> "required"
            ]);
            User::create([
                "fname" => $request->fname,
                "lname" => $request->lname,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "isUserPrivileged" => $request->isUserPrivileged,
            ]);
            return response()->json(['response' => 'success']);
        } catch (ValidationException $e) {
            return response(['error' => $e->validator->errors()], 422);
        }
    }
    public function GetClients(){
        try {
            $clients = Clients::all();
            return view('components.Card', compact('clients'));
            dd($clients);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
