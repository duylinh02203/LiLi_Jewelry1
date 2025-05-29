<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\UserInfor;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showContactForm()
    {
        $userData = null;

        if (session()->has('userData')) {
            $sessionUserData = session('userData');

            $userInfor = UserInfor::where('user_id', $sessionUserData['id'])->first();

            $userData = [
                'email' => $sessionUserData['email'],
                'phone' => $userInfor->phone ?? null,
            ];
        }

        return view('cms.contact.contact', compact('userData'));
    }
}
