<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginCustomer(Request $request)
    {
        $role = $request->role;

        return view('auth.login', ['role' => $role]);
    }
}
