<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Http\Response;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\GroupRequest;

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
    public function store(GroupRequest $request)
{
    
    $data = $request->validated();
    
    $created_group = Group::create($data);

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
    public function update(GroupRequest $request, Group $group)
    {
       
        $data = $request->validated();
        $group->update($data);
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        
        // foreach ($group->lessons as $lesson) {
        //     $lesson->lessons()->delete();
        // }
        // $group->delete();
        // return response(null, Response::HTTP_NO_CONTENT);
        $group->lessons()->delete(); 

        // Удаление группы после удаления уроков
        $group->delete();
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
