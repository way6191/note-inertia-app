<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // 用户登录
    public function login()
    {
        return Inertia::render('Login');
    }

    // 用户认证
    public function auth()
    {
        if (auth()->attempt(
            [
                'name' => request()->username,
                'password' => request()->password
            ]
        )) {
            request()->session()->regenerate();

            return redirect('/');
        }

        return back();
    }

    // 用户注销
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
