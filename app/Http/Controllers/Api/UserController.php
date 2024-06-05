<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Family_account;
use App\Models\Child_profile;
use App\Models\Trusted_person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


   
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = Auth::user();
    
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'The old password is incorrect'], 400);
        }
    
        $request->user()->fill(['password' => Hash::make($request->new_password)])->save();

    
        return response()->json(['message' => 'Password changed successfully']);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        foreach ($user->family_accounts as $familyAccount) {
            $familyAccount->child_profiles()->delete();
        }
 
        foreach ($user->family_accounts as $familyAccount) {
            $familyAccount->trusted_persons()->delete();
        }


        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
