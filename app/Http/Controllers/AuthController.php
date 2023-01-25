<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('do_logout');
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }


    public function do_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'redirect' => 'reload',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Password anda salah',
                'redirect' => 'reload',
            ]);
        }
    }

    public function do_register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'nim' => 'required|unique:mahasiswas,nim',
            'email' => 'required|email|regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/|unique:users',
            'password' => 'required|min:8',
            'confirm-password' => 'required|same:password',
            'toc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }
        $mahasiswa = new Mahasiswa;
        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->nama = $request->name;
        $user->save();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->user_id = $user->id;
        $mahasiswa->save();
        auth()->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendaftar',
            'redirect' => route('dashboard'),
        ]);
    }

    public function do_logout()
    {
        // logout
        Auth::logout();
        // redirect
        return redirect()->route('login');
    }

}