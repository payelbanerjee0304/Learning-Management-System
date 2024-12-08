<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Admin;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }

    public function save(Request $request)
    {
        $mobile = $request->input('mobile');
        // print_r($mobile);die;
        $mobileInt = (int) $mobile;
        $admin = Admin::where('phone', '=', $mobile)->get();
        // print_r($admin);die;

        if (empty($admin[0])) {
            return response()->json(['status' => 'error', 'message' => 'Admin not found']);
        } else {
            $otp = rand(100000, 999999);
            $var = ['otp' => $otp];
            Admin::where('phone', '=', $mobile)->update($var);
            $getDataOtp = Admin::where('phone', '=', $mobile)->get();
            return response($getDataOtp);
        }
    }
    public function verifyAndLogin(Request $request)
    {
        $mobile = $request->input('mobile');
        $mobileInt = (int) $mobile;
        $otp = $request->input('otp');
        $admin = Admin::where('phone', '=', $mobile)->get();
        if (empty($otp)) {
            return response()->json(['status' => 'error', 'message' => 'Please Enter Your One Time Password'], 404);
        } else if ($admin[0]['otp'] != $otp) {
            return response()->json(['status' => 'error', 'message' => 'Wrong OTP'], 404);
        } else {
            Session::put('admin', $admin);
            session(['admin_id' => $admin[0]['_id']]);
            if (Session::has('admin_id')) {
                $userId = Session::get('admin_id');
                return response()->json(['status' => 'success', 'admin' => $admin]);
            } else {
                echo "Admin ID session variable not set";
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        return redirect('admin/login')->with('message', 'Logout successfully');
    }
}
