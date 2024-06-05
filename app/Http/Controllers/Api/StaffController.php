<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use App\Http\Resources\GroupStaffResource;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Models\Child_profile;
use App\Http\Requests\StaffRequest;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Response;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return GroupResource::collection(Group::all());
        return StaffResource::collection(Staff::all());
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
    public function show(Staff $staff)
    {
        //
        return new StaffResource($staff);
    }


    public function staffsWithoutGroup(Request $request)
    {
        $staffs = Staff::whereNull('group_id')->get();
        return GroupStaffResource::collection($staffs);
    }

    public function staffsWithGroup($child_id){

        $childProfile = Child_profile::find($child_id);
        if (!$childProfile) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }
        $groupId = $childProfile->group_id;

        if (is_null($groupId)) {
            return response()->json(['error' => 'Group ID not found for this child'], 404);
        }

        $staffs = Staff::where('group_id', $groupId)->get();
        return StaffResource::collection($staffs);

    }

    /**
     * Update the specified resource in storage.
     * 
     * 
     */
    
    public function update(StaffRequest $request, Staff $staff)
    {

        /** @var \App\Models\User */
        $user = Auth::user();
        

        if (!$user->hasRole('admin') &&  $user->id !== $staff->user_id) {
            return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        }
        
        $data = $request->validated();

        try{
            Helper::processBase64Image($request, $data);

        $staff->update($data);

        return new StaffResource($staff);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        
    }
} 