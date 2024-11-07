<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        // panggil controller CompanyController
        $companyController = new CompanyController();
        $companyCheckData = $companyController->companyCheck();

        if($companyCheckData->json('success') == false) {
            return redirect()->route('company-not-found')->with('error', $companyCheckData->json('message'));
        } else {
            return view("auth.login");
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $response = Http::post(env('API_URL') . '/api/admin/user/login', [
                'email' => $request->email,
                'password' => $request->password
            ]);

            if ($response->successful() && $response->json('success')) {
                $data = $response->json('data');

                Session::put('token', $data['token']);
                Session::put('user', $data['user']);

                return redirect()->route('index')->with('success', 'Login berhasil');
            } else {
                return redirect()->back()->with('error', $response->json('message'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Logout berhasil');
    }

    public function showChangePassword()
    {
        return view("auth.change-password");
    }

    public function showForgotPassword()
    {
        return view("auth.forgot-password");
    }
}
