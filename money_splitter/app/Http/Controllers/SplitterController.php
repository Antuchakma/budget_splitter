<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
class SplitterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('index', compact('user'));
    }

    // ---------------- Authentication ----------------
    public function signup()
    {
        return view('joinus');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Redirect to home/index
        return redirect()->route('room_list')->with('success', 'Account created successfully!');
    }

    public function login()
    {
        return view('joinus');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('room_list')->with('success', 'Welcome back!');
        }

        return redirect()->back()->withErrors(['login' => 'Invalid username or password.'])->withInput($request->only('name'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
