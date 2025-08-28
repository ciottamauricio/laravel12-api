<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $response = Http::post(config('app.url') . '/api/auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Session::put('api_token', $data['access_token']);
                Session::put('user', $data['user'] ?? null);

                return redirect()->intended('/customers');
            }

            return redirect()->back()
                ->withErrors(['email' => 'Invalid credentials'])
                ->withInput();

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Login failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function logout()
    {
        Session::forget(['api_token', 'user']);
        return redirect('/login');
    }
}
