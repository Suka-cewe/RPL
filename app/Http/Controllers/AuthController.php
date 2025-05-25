<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display login form.
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Display admin login form.
     */
    public function adminLoginForm()
    {
        return view('auth.admin_login');
    }

    /**
     * Display siswa login form.
     */
    public function siswaLoginForm()
    {
        return view('auth.siswa_login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        // Different validation rules based on role
        if ($request->role === 'admin') {
            $request->validate([
                'nip' => ['required', 'string'],
                'password' => ['required'],
            ]);

            // Find admin by NIP
            $admin = User::where('nip', $request->nip)
                ->where('role', 'admin')
                ->first();

            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return back()->withErrors([
                    'nip' => 'NIP atau password tidak valid.',
                ])->withInput();
            }

            Auth::login($admin, $request->boolean('remember'));

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } else {
            // Student login with username
            $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required'],
            ]);

            // Find student by username
            $student = User::where('username', $request->username)
                ->where('role', 'siswa')
                ->first();

            if (!$student || !Hash::check($request->password, $student->password)) {
                return back()->withErrors([
                    'username' => 'Username atau password tidak valid.',
                ])->withInput();
            }

            Auth::login($student, $request->boolean('remember'));

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
