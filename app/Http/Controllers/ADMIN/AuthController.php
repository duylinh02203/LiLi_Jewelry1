<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginAction(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            $user = Auth::user();
            if ($user->role != 1) {
                return redirect()->back()->withErrors([
                    'infor' => 'Bạn không có quyền truy cập',
                ])->withInput();
            }
            $request->session()->regenerate();
            session(['userData' => $user]);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors([
                'infor' => 'thông tin đăng nhập không chính xác',
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
