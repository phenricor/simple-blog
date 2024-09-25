<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password'  => 'required|alphaNum|min:3'
        ]);
        $user_data = array(
            'name'  => $request->get('username'),
            'password' => $request->get('password')
        );

        if (Auth::attempt($user_data)) {
            return redirect()->route("posts.index")->with("success", "Successfully logged in!");
        } else {
            return back()->with('error', 'Wrong Login Details');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("posts.index");
    }
}
