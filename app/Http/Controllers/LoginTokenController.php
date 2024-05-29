<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return ['token' => $user->createToken($request->device_name)->plainTextToken,
                'id'=>$user->id,
                'family_account_id' => $user->family_accounts->isNotEmpty() ? $user->family_accounts->pluck('id') : [],
                ];
    }

    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
