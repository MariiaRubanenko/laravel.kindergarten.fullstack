<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use App\Http\Resources\GroupStaffResource;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
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

        // return response()->json($children);
        return GroupStaffResource::collection($staffs);
    }


    /**
     * Update the specified resource in storage.
     * 
     * 
     */
    //public function update(StaffRequest $request, Staff $staff)
    
    public function update(StaffRequest $request, Staff $staff)
    {
        //
 
        // if ((Auth::id() !== $staff->user_id)) {
        //     return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        // } 
       
      
    // if ((Auth::id() !== $staff->user_id) && !Auth::user()->hasRole('admin')) {
    //     return response()->json(['error' => 'You are not authorized to update this profile'], 403);
    // }


        // if (!Auth::user()->hasRole('admin') ||  Auth::id() !== $staff->user_id) {
        //     return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        // }

        /** @var \App\Models\User */
        $user = Auth::user();
        

        if (!$user->hasRole('admin') &&  $user->id !== $staff->user_id) {
            return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        }
          
        //   $user = auth()->user();
        // if (!auth()->user()->hasRole('admin') && auth()->id() !== $staff->user_id) {
        //     return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        // }
        
        $data = $request->validated();

        try{

            // Helper::processImage($request, $data);
            Helper::processBase64Image($request, $data);

        $staff->update($data);

        return new StaffResource($staff);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
    }

    // public function saveImage(ImageRequest $request){

    //     $data = $request->validated();

    //     try{

    //         Helper::processImage($request, $data);

    //     $staff->update($data);

    //     return new StaffResource($staff);

    // } catch (\Exception $e) {
    //     return response()->json(['error' => $e->getMessage()], 400);
    // }


    // }
    // public function saveImage(ImageRequest $request){

    //     $data = $request->validated();
    
    //     try{
    //         // Отримання id з запиту
    //         $id = 38;
    
    //         // Пошук запису за вказаним id
    //         $staff = Staff::find($id);
    
    //         // Обробка зображення
    //         Helper::processImage($request, $data);
    
    //         // Оновлення запису
    //         $staff->update($data);
    
    //         return new StaffResource($staff);
            
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // 
        // $staff->delete();
        // return response(null, Response::HTTP_NO_CONTENT);
    }
} 