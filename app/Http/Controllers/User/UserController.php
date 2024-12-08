<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function save(Request $request)
    {
        $request->validate([]);

        // $email = $request->input('email');
        // $password = md5($request->input('password'));
        $mobile = $request->input('mobile');
        $user = DB::table("users")->where('phone', '=', $mobile)->orWhere('phone', '=', (int)$mobile)->where('isDeleted', false)->get();

        if (empty($user[0])) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }
        // else if ($user[0]['password']!=$password) {
        //     return response()->json(['status' => 'error', 'message' => 'Password is incorrect']);
        // } 
        else {
            $otp = rand(100000, 999999);
            $var = ['otp' => $otp];
            DB::table('users')->where('phone', '=', $mobile)->orWhere('phone', '=', (int)$mobile)->where('isDeleted', false)->update($var);
            $getDataOtp = DB::table('users')->where('phone', '=', $mobile)->orWhere('phone', '=', (int)$mobile)->where('isDeleted', false)->get();


            $url = "https://sms.smscollection.com/api/default.aspx";

            // Prepare the query parameters
            $params = [
                'user' => 'terapanthcard',
                'password' => 'sms123',
                'sender' => 'TRPNET',
                'phonenumber' => $mobile,
                'group' => '',
                'text' => "Your OTP for card.terapanthnetwork.com is {$otp}\n\nTerapanth Network",
                'unicode' => 1,
                'dlttemplateid' => '1007319005198258163'
            ];

            // Send the request
            // $response = Http::get($url, $params);


            return response($getDataOtp);
        }
    }
    public function verifyAndLogin(Request $request)
    {

        // $email=$request->input('email');
        // $password=md5($request->input('password'));
        $mobile = $request->input('mobile');
        $otp = $request->input('otp');
        $user = DB::table('users')->where('phone', '=', $mobile)->orWhere('phone', '=', (int)$mobile)->where('isDeleted', false)->get();
        // console.log($userDetails);
        if (empty($otp)) {
            return response()->json(['status' => 'error', 'message' => 'Please Enter Your One Time Password'], 404);
        } else if ($user[0]['otp'] != $otp) {
            return response()->json(['status' => 'error', 'message' => 'Wrong OTP'], 404);
        } else {
            // return response()->json(['status' => 'success', 'message' => 'Form submitted successfully']);
            Session::put('user', $user);
            session(['user_id' => $user[0]['_id']]);
            if (Session::has('user_id')) {
                // Retrieve the value of the session variable
                $userId = Session::get('user_id');
                // Use or display the value
                // session(['user_id' => $user[0]->id]);
                $loggedInUserId = (string) Session::get('user_id');
                // ActivityLogHelper::log($loggedInUserId, 'User login', 'User logged in with ID ' . $loggedInUserId);
                return response()->json(['status' => 'success', 'user' => $user]);
            } else {
                echo "User ID session variable not set";
            }
        }
    }
    public function logout(Request $request)
    {
        $loggedInUserId = (string) Session::get('user_id');

        $request->session()->forget('user_id');

        return redirect('/login')->with('message', 'Logout successfully');
    }
}
