<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function index()
    {
        $user = User::where('role', 'user')->get();


        return view('admin.dashboard', compact('user'));

    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin-dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function EditProfileForm($email)
    {
        $user = Userinfo::where('email', $email)->firstOrFail();
        return view('admin.editprofile', compact('user'));
    }

    public function EditProfile(request $request)
    {
       $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:255',
        'phone_number' => 'required|string|max:10',
       ]);

       $user = Userinfo::where('email', $request->email)->first();
       $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
       ]);
       return redirect('/admin-dashboard')->with('success', 'Profile updated successfully!');
    }
}