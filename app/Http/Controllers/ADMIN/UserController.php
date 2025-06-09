<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Models\UserInfor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function listUser()
    {

        $users = User::where('role', 2)->paginate(5);
        return view('admin.users.user', compact('users'));
    }

    public function listAdmin()
    {
        $admins = User::where('role', 1)->paginate(5);
        return view('admin.users.admin', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.create_user');
    }

    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ];
            $createdUser = User::create($data);
            if (!$createdUser) {
                DB::rollBack();
                return redirect()->route('admin.user.create')->with('error', 'User creation failed.');
            } else {
                UserInfor::create([
                    'user_id' => $createdUser->id,
                    'phone' => $request->phone,
                ]);
                DB::commit();
                if ($request->role == 1) {
                    return redirect()->route('admin.user.listAdmin')->with('success', 'Thêm quản trị viên thành công.');
                } else {
                    return redirect()->route('admin.user.listUser')->with('success', 'Thêm người dùng thành công.');
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.user.create')->with('error', 'Lỗi thêm người dùng: ' . $th->getMessage());
        }
    }

    public function editForm($id)
    {
        $userUpdate = User::find($id);
        return view('admin.users.edit_user', compact('userUpdate'));
    }
    public function edit(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('admin.user.listUser')->with('error', 'User not found.');
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];
            if ($request->password) {
                $data['password'] = $request->password;
            }
            $user->update($data);
            $user->userInfor()->update([
                'phone' => $request->phone,
            ]);

            DB::commit();
            if ($request->role == 1) {
                return redirect()->route('admin.user.listAdmin')->with('success', 'Chỉnh sửa quản trị viên thành công.');
            } else {
                return redirect()->route('admin.user.listUser')->with('success', 'Chỉnh sửa người dùng thành công.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.user.editForm', ['id' => $id])->with('error', 'Error updating user: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('admin.user.listUser')->with('error', 'User not found.');
            }
            $user->delete();
            $userInfor = UserInfor::where('user_id',$user->id)->first();
            $userInfor->delete();
            DB::commit();
            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.user.listUser')->with('error', 'Error deleting user: ' . $th->getMessage());
        }
    }

    public function searchUser(Request $request)
    {
        $search = $request->search;
        $users = User::where('role', 2)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->paginate(5);
        return view('admin.users.user', compact('users'));
    }

    public function searchAdmin(Request $request)
    {
        $search = $request->search;
        $admins = User::where('role', 1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->paginate(5);
        return view('admin.users.admin', compact('admins'));
    }
    public function detail($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.detail', compact('user'));
    }
}
