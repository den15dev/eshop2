<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Log\LogService;
use App\Modules\Users\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:100', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        LogService::writeEventLog(
            'registration',
            [
                'id' => $user->id,
                'name' => $user->name,
            ]
        );

        return response()->json([
            'status' => 'registered',
            'message' => [
                'welcome' => __('auth.modal.registration_success.welcome', ['name' => $user->name]),
                'link_sent' => __('auth.modal.registration_success.link_sent', ['address' => $user->email]),
            ],
        ]);
    }
}
