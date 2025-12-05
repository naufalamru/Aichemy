<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:30',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|max:25|unique:users,username',
            'password' => 'required|string|min:8|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',

            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ];
    }
}
