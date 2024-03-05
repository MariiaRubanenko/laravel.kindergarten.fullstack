<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChildProfileResource;
use App\Models\Child_profile;
use Illuminate\Http\Request;

class Child_profileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return UserResource::collection(User::with('family_accounts')->get());
        return ChildProfileResource::collection(Child_profile::with('attendances')->get());
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
        return new ChildProfileResource(Child_profile::with('attendances')->findOrFail($id));
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
