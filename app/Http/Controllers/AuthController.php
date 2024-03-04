<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

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

        /**
         * We are authenticating a request from our frontend.
         */
        if (EnsureFrontendRequestsAreStateful::fromFrontend(request())) {
            $this->authenticateFrontend();
        }
        /**
         * We are authenticating a request from a 3rd party.
         */
        else {
            // Use token authentication.
        }

        // $user = User::where('email', request('email'))->first();

        // if ($user) {
        //     if (Hash::check(request('password'), $user->password)) {
        //         return [
        //             'token' => $user->createToken(time())->plainTextToken
        //         ];
        //     }
        // }

        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }

    public function logout()
    {
        if (EnsureFrontendRequestsAreStateful::fromFrontend(request())) {
            Auth::guard('web')->logout();

            request()->session()->invalidate();

            request()->session()->regenerateToken();
        } else {
            // Revoke token
        }
        // auth()->user()->currentAccessToken()->delete();
    }

    private function authenticateFrontend()
    {
        if (! Auth::guard('web')
            ->attempt(
                request()->only('email', 'password'),
                request()->boolean('remember')
            )) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
