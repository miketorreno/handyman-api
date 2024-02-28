<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth
 */


class AuthController extends Controller
{
    /**
     * @bodyParam email email required
     * @bodyParam password required
     */
    public function login()
    {
        validator(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        $user = User::where('email', request('email'))->first();

        if ($user) {
            if (Hash::check(request('password'), $user->password)) {
                return [
                    'token' => $user->createToken(time())->plainTextToken
                ];
            }
        }
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
