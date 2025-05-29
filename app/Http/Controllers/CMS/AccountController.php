<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {   
        $user = session('userData');
        return view('cms.account.index',compact('user'));
    }
}
