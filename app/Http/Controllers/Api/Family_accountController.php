<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamilyAccountResource;
use App\Models\Family_account;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\FamilyAccountRequest;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class Family_accountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return UserResource::collection(User::with('family_accounts')->get());
        return FamilyAccountResource::collection(Family_account::with('child_profiles')->get());
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
    public function show(string $id)
    {
        //return new UserResource(User::with('family_accounts')->findOrFail($id));
        return new FamilyAccountResource(Family_account::with('child_profiles')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyAccountRequest $request, Family_account $family_account)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        

        if (!$user->hasRole('admin') &&  $user->id !== $family_account->user_id) {
            return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        }
          
        $data = $request->validated();
        try{

            Helper::processImage($request, $data);

        $family_account->update($data);

        return new FamilyAccountResource($family_account);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family_account $family_account)
    {
        //
        $family_account->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
