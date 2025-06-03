<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeUserInforRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\ForgotPassword;
use App\Models\User;
use App\Models\UserInfor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function checkout()
    {
        return view('cms.checkout.checkout');
    }

    public function login()
    {
        if (session()->has('userData')) {
            return redirect()->back();
        }
        return view('cms.auth.login');
    }

    public function register()
    {
        return view('cms.auth.register');
    }

    public function registerAction(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            $createUser = User::create($data);
            if ($createUser) {
                UserInfor::create([
                    'user_id' => $createUser->id,
                    'phone' => $request->phone,
                ]);
                DB::commit();
                return redirect()->route('login')->with('success', 'Đăng kí tài khoản thành công !');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng kí tài khoản thất bại !');
        }
    }

    public function loginAction(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            session(['userData' => Auth::user()]);
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'infor' => 'Thông tin đăng nhập không chính xác',
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('cms.auth.forgot_password');
    }

    public function forgotPasswordAction(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['infor' => 'Email không tồn tại !']);
        }
        $password = random_int(100000, 999999);
        $user->update([
            'password' => Hash::make($password),
        ]);
        ForgotPassword::dispatch($user, $password);
        return redirect()->route('login')->with('success', 'Mật khẩu mới đã được gửi qua Email của bạn');
    }
}
