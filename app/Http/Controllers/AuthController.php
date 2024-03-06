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
     * @bodyParam name required
     * @bodyParam email email required
     * @bodyParam password required
     * @bodyParam password_confirmation required
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // validator(request()->all(), [
        //     'name' => ['required', 'string'],
        //     'email' => ['required', 'email', 'unique:users,email'],
        //     'password' => ['required', 'confirmed'],
        // ])->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken(time())->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    /**
     * @bodyParam email email required
     * @bodyParam password required
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);
        
        // validator(request()->all(), [
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ])->validate();

        if (EnsureFrontendRequestsAreStateful::fromFrontend(request())) {   // * 1st party frontend
            $this->authenticateFrontend();
        } else {    // * 3rd party frontend
            $user = User::where('email', $request->email)->first();
    
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken(time())->plainTextToken;
                    $response = [
                        'user' => $user,
                        'token' => $token,
                    ];

                    return response($response, 200);
                }

                $response = [
                    'message' => 'Incorrect password.'
                ];
                return response($response, 400);
            }

            $response = [
                'message' => 'The provided credentials do not match our records.'
            ];
            return response($response, 400);
        }
    }

    public function logout()
    {
        if (EnsureFrontendRequestsAreStateful::fromFrontend(request())) {
            Auth::guard('web')->logout();

            request()->session()->invalidate();

            request()->session()->regenerateToken();
        } else {
            if (auth()->user()->currentAccessToken()) {
                auth()->user()->currentAccessToken()->delete();
                $response = [
                    'message' => 'Logged out'
                ];

                return response($response, 200);
            }

            $response = [
                'message' => 'Please login first'
            ];
            return response($response, 200);
        }
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
