<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChildProfileRequest;
use App\Http\Resources\ChildProfileResource;
use App\Http\Resources\FamilyAccountChildProfileResource;
use App\Models\Child_profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class Child_profileController extends Controller
{
    
    public function index()
    {
        
        return ChildProfileResource::collection(Child_profile::with('attendances')->get());
        
    }

    public function childrenWithoutGroup(Request $request)
    {
        $children = Child_profile::whereNull('group_id')->get();

        // return response()->json($children);
        return FamilyAccountChildProfileResource::collection($children);
    }





    public function store(ChildProfileRequest $request)
{





    $data = $request->validated();

    try{
    // Проверяем, было ли загружено изображение
    // if ($request->hasFile('image')) {
    //     $image = $request->file('image');
    //     $imageName = time().'.'.$image->extension();
    //     // $imageData = file_get_contents($image->path());
    //     $imageData = $image->get();

    //     // Добавляем информацию об изображении к данным для сохранения
    //     $data['image_name'] = $imageName;
    //     $data['image_data'] = $imageData;
    // } else {
    //     // Если изображение не было загружено, добавляем поля с null значениями
    //     $data['image_name'] = null;
    //     $data['image_data'] = null;
    // }
    // dd($data);
    // Создаем профиль ребенка
    
    Helper::processImage($request, $data);
    $childProfile = Child_profile::create($data);

    return response()->json(['message' => 'Child profile created successfully', 'name' => $childProfile->name], 201, [], JSON_UNESCAPED_UNICODE);


    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}



    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //return new UserResource(User::with('family_accounts')->findOrFail($id));
    //     return new ChildProfileResource(Child_profile::with('attendances')->findOrFail($id));
    // }
    public function show($id)
    {

        //return new UserResource(User::with('family_accounts')->findOrFail($id));
        
        //  $childProfile = Child_profile::findOrFail($id);

        //  return new ChildProfileResource($childProfile);
        
         return new ChildProfileResource(Child_profile::with('attendances')->findOrFail($id));
        
    }



    public function update(ChildprofileRequest $request, Child_profile $childProfile)
    {
       
        /** @var \App\Models\User */
        $user = Auth::user();
        

        if(!$user->hasRole('admin'))
        {

        
            // Получить все child_profiles, связанные с family_accounts текущего пользователя
            $editableChildProfileIds = Child_profile::whereIn('family_account_id', function($query) use ($user) {
                $query->select('id')
                    ->from('family_accounts')
                    ->where('user_id', $user->id);
            })->pluck('id')->toArray();

            // Проверить, есть ли у пользователя доступ к редактированию этого child_profile
            if (!in_array($childProfile->id, $editableChildProfileIds)) {
                return response()->json(['error' => 'Hands off! This is not your child.'], 403);
            }
        }

        // if (!$user->hasRole('admin') &&  $user->id !== $staff->user_id) {
        //     return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        // }

        // if (!$user->hasRole('admin') &&  $user->id !== $family_account_id->user_id) {
        //     return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        // }

        $data = $request->validated();

    try{
    // Проверяем, было ли загружено изображение
    // if ($request->hasFile('image')) {
    //     $image = $request->file('image');
    //     $originalName = $image->getClientOriginalName();
    //     $extension = $image->extension();
    //     $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
    //     $imageData = $image->get();

    //     // Добавляем информацию об изображении к данным для сохранения
    //     $data['image_name'] = $imageName;
    //     $data['image_data'] = $imageData;
    // } 
 
    Helper::processImage($request, $data);
    
    $childProfile->update($data);


        return new ChildProfileResource($childProfile);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
        //
    }

    
    public function destroy(Child_profile $childProfile)
    {
        $childProfile->delete();
        return response(null, Response::HTTP_NO_CONTENT);

        //
    }
}
