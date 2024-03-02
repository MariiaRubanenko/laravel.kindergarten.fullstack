<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamilyAccountResource;
use App\Models\Family_account;
use Illuminate\Http\Request;

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
