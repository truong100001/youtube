<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function  postLogin(Request $request)
    {
        $this->validate($request,[
            'email' => 'bail|required|email',
            'password' => 'bail|required'
        ],[
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu không được để trống'
        ]);

        if(Auth::attempt(['email' => $request->email,'password' => $request->password]))
        {
            return redirect('/');
        }
        else
        {
            return redirect()->back()->with('message','Email hoặc mật khẩu không chính xác');
        }
    }

    public function Logout()
    {
        if(Auth::check())
        {
            Auth::logout();
            return redirect('/login');
        }

    }
}
