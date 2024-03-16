<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChildProfileRequest;
use App\Http\Resources\ChildProfileResource;
use App\Models\Child_profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class Child_profileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return ChildProfileResource::collection(Child_profile::with('attendances')->get());
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChildProfileRequest $request)
{
    $data = $request->validated();

    try{
    // Проверяем, было ли загружено изображение
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        // $imageData = file_get_contents($image->path());
        $imageData = $image->get();

        // Добавляем информацию об изображении к данным для сохранения
        $data['image_name'] = $imageName;
        $data['image_data'] = $imageData;
    } else {
        // Если изображение не было загружено, добавляем поля с null значениями
        $data['image_name'] = null;
        $data['image_data'] = null;
    }
    // dd($data);
    // Создаем профиль ребенка
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


        
         $childProfile = Child_profile::findOrFail($id);

        //  if ($childProfile->image_data) {
        //     return $this->getImageResponse($childProfile->image_data);
        // }
         
       
         return new ChildProfileResource($childProfile);
        
        
    }


//     private function getImageResponse($imageData)
// {
//     return response($imageData, 200)->header('Content-Type', 'image/png');
// }


    /**
     * Update the specified resource in storage.
     */
    public function update(ChildprofileRequest $request, Child_profile $childProfile)
    {
        $childProfile->update($request->validated());

        return new ChildProfileResource($childProfile);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Child_profile $childProfile)
    {
        $childProfile->delete();
        return response(null, Response::HTTP_NO_CONTENT);

        //
    }
}
