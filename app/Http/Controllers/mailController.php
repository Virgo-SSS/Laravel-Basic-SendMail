<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sended;
use App\Mail\TestingMail;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;

class mailController extends Controller
{

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|indisposable',
        ]);
        dd('success');
        
        $userCheck = User::where('id', Auth::user()->id)
        ->where('email', $request->email)
        // ->where('status_email',0)
        ->first(['id','email','status_email']);
        // dd($userCheck);
        if($userCheck == null) {
            return back()->with('error', 'Email anda Tidak cocok dengan akun anda');

        }

        if($userCheck->status_email == 0) {
            $userID = $userCheck->id;
            $userEMAIL = $userCheck->email;
            
            // sended is for check link email expired or not
            Sended::Create([
                // is done = 0 -> not done, user didn't click the email link
                // is done = 1 -> done, verified
                // is done = 2 -> done, but email not verified, bcs expired
                'user_id' => Auth::user()->id,
                'email' => $userCheck->email,
                'is_done' => 0,
                'created_at' => Carbon::now()

            ]);
            
            $checkEmail = sended::where('user_id', Auth::user()->id)->first();
            $token = Hash::make($checkEmail->created_at . $checkEmail->user_id);
            $link = route('email.send', ['userID' => $userID, 'userEMAIL' => $userEMAIL]) . '?' . http_build_query(['t' => $token]);

            Mail::to($userCheck->email)->send(new TestingMail($userID, $link));
            // dispatch(new SendEmailJob($userEMAIL,$userID,$link))->onQueue('email');

            return back()->with('success', 'Email berhasil dikirim');
            
        } 
        
        if($userCheck->status_email == 1) {
            return back()->with('error', 'Email already verified');
        }
        
   
           
    }
    
    public function sendEmail($id,$email)
    {
        $token = $this->verifToken($id);
        if($token == 400){
            return back()->with('error', 'Link Tidak Valid');
        }
        $user = User::where('id', $id)
        ->where('email', $email)
        ->first(['id','email','status_email']);

        
        if($user) {
            if($user->status_email == 1) {
                return back()->with('error', 'Email already verified');
            }
            $cek = sended::where('user_id', $id)
            ->where('email', $user->email)
            ->where('is_done', 0)
            ->first(['id','email','is_done','created_at']);
            if($cek == null) {
                return redirect()->route('home')->with('error', 'link sudah expired');
            }
            $to = new Carbon($cek->created_at);
            $from = Carbon::now();
    
            $diff_in_minutes = $to->diffInMinutes($from);
            if($diff_in_minutes > 3) {
                // dd($diff_in_minutes);
                $cek->is_done = 2;
                $cek->save();
                $cekLagi = sended::where('user_id', $id)
                    ->where('email', $user->email)
                    ->where('is_done', 0);
                if($cekLagi) {
                    $cekLagi->delete();
                }
                return redirect()->route('home')->with('error', 'link sudah expired');
            }
            
            $user->status_email = 1;
            $user->save();
            $cek->is_done = 1;
            $cek->save();
            $cekLagi = sended::where('user_id', $id)
                        ->where('email', $user->email)
                        ->where('is_done', 0);
            if($cekLagi) {
                $cekLagi->delete();
            }
           
            return redirect()->route('home')->with('success', 'Email verified successfully');     
        } 


    }

    public function verifToken($id)
    {
        $token = request()->query('t');
        $send = sended::where('user_id', $id)->first();
        
        $cek = "";
        if(!Hash::check($send->created_at . $send->user_id, $token)) $cek = 400;

        return $cek;

    }

    public function test()
    {
        $test = sended::where('id', 40)->first(['created_at']);
        
        if(Carbon::now() > $test->created_at) {
            $test = Carbon::parse($test->created_at)->format('Y-m-d');
        }
        return view('home', compact('test'));
    }
   
}
