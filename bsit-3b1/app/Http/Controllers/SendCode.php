<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Arr;
use App\Forgot;
use App\User;

class SendCode extends Controller
{
    public function send(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $v = Forgot::where('email', $request->email)->get();

        if(count($v) == 0) {
            return response()->json(['error' => 'This email is not registered'], 401);
        }

        $codeArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        $code = '';

        for($i = 0; $i < 5; $i++)
        {
            $code = $code . Arr::random($codeArray);
        }

        Mail::send(new SendMail($request->email, $code));

        $f = new Forgot();
        $f->email = $request->email;
        $f->code = $code;
        $f->save();

        return response()->json(['success', 'Code Sent to your email'], 200);
    }

    public function verifyCode(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:forgots'
        ]);

        $user = Forgot::where('email', $request->email)
                    ->orWhere('code', $request->code)
                    ->get();

        if(count($user) == 0) {
            return response()->json(['error', 'invalid email'], 401);
        }

        return response()->json(['success', 'Code Verified'], 200);
    }

    public function validateEmail($email)
    {
        $user = Forgot::where('email', $email)->get();

        if(count($user) == 0) {
            return response()->json(['error', 'invalid email'], 401);
        }

        return response()->json(['success', 'valid email'], 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->get();

        if(count($user) == 0) {
            return response()->json(['error' => 'Invalid Email'], 401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $f = Forgot::where('email', $request->email);
        $f->delete();

        return response()->json(['success' => 'Password changed successfully'], 200);
    }
}
