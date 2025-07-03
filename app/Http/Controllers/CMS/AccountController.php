<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordUser;
use App\Http\Requests\Auth\ChangeUserInforRequest;
use Illuminate\Http\Request;
use App\Models\UserInfor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{

    public function information()
    {
        $user = session()->get('userData');
        $userInfor = $user->userInfor;
        return view('cms.user.information_user', compact('user', 'userInfor'));
    }

    public function changeUserInfor(ChangeUserInforRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = session('userData');
            $userChange = User::find($user->id);
            $userChange->update([
                'name' => $request->name,
            ]);
            $userInfor = UserInfor::where('user_id', $userChange->id)->first();
            $userInfor->update([
                'phone' => $request->phone,
                'address' => $request->address ?? null,
                'district' => $request->district ?? null,
                'province' => $request->province ?? null,
            ]);
            DB::commit();
            session(['userData' => $userChange->load('userInfor')]);
            return redirect()->back()->with('success', 'Chỉnh sửa thông tin thành công !');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Thay đổi thông tin thất bại');
        }
    }

    public function formChangePassword()
    {
        return view('cms.user.change_password');
    }

    public function changePassword(ChangePasswordUser $request)
    {
        DB::beginTransaction();
        try {
            $user = session('userData');
            $userChange = User::find($user->id);
            $userChange->update([
                'password' => Hash::make($request->new_password),
            ]);
            DB::commit();
            session(['userData' => $userChange->load('userInfor')]);
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công !');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Thay đổi thông tin thất bại');
        }
    }
}
