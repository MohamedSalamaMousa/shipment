<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\services\ExternalAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    public function __construct(private ExternalAuthService $authService) {}

    public function view(): \Illuminate\View\View
    {
        return view('auth.register');
    }
    public function register(RegisterUserRequest $request): RedirectResponse
    {


        $response = $this->authService->register($request->validated());

        if ($response->successful()) {
            $token = $response['data']['token'] ?? null;
            session(['user_token' => $token]);

            if ($token) {
                session(['user_data' => $response['data']]);
                return redirect()->route('home')->with('success', 'تم التسجيل بنجاح');
            }

            return redirect()->back()->with('error', 'فشل التسجيل: التوكن غير موجود.');
        } else {
            // التعامل مع الأخطاء القادمة من الـ API
            $errors = $response->json('errors'); // يرجع مصفوفة الأخطاء
            $message = $response->json('message'); // رسالة عامة

            return redirect()->back()->withErrors($errors)->with('error', $message);
        }
    }
    public function performLogin(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        // Send request to external API
        $response = Http::post('https://admin.tetexexpress.com/api/user/login', [
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ]);

        if ($response->successful() && $response->json('success')) {
            $data = $response->json('data');
            session(['user_token' => $data['token']]);
            session(['user_data' => $data]);

            return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return redirect()->back()->with('error', 'فشل تسجيل الدخول: ' . ($response->json('message') ?? 'حدث خطأ ما'));
    }
    public function logout(Request $request): RedirectResponse
    {
        // تنظيف بيانات الجلسة بشكل آمن
        $request->session()->flush();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}