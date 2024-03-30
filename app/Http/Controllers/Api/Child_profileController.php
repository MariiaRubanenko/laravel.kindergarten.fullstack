<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChildProfileRequest;
use App\Http\Resources\ChildProfileResource;
use App\Models\Child_profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Helpers\Helper;


class Child_profileController extends Controller
{
    
    public function index()
    {
        
        return ChildProfileResource::collection(Child_profile::with('attendances')->get());
        
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
