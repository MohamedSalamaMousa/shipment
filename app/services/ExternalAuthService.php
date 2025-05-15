<?php

namespace App\services;

use Illuminate\Support\Facades\Http;

class ExternalAuthService
{
    public function register(array $data)
    {
        return Http::post('https://admin.tetexexpress.com/api/user/register', [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'password_confirmation' => $data['password_confirmation'],
        ]);
    }
}