<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return UserResource::collection(User::with('family_accounts')->get());
       // return GroupResource::collection(Group::with('staffs')->get());
       return GroupResource::collection(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $created_group = Group::create($validatedData);

    return new GroupResource($created_group);
}


    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
        // $group = Group::findOrFail($id);

        return new GroupResource($group);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $group = Group::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $group->update($validatedData);
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //

        $group->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
