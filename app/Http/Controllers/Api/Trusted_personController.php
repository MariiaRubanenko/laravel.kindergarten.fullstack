<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrustedPersonRequest;
use App\Http\Resources\TrustedPersonResource;
use Illuminate\Http\Request;
use App\Models\Trusted_person;
use Illuminate\Http\Response;
use App\Http\Helpers\Helper;


class Trusted_personController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return TrustedPersonResource::collection(Trusted_person::all());

        //return GroupResource::collection(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrustedPersonRequest $request)
    {
        //
        // $data = $request->validated();

        // $trusted_person=Trusted_person::create($data);

        $data = $request->validated();


        try{
            // // Проверяем, было ли загружено изображение
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
            $trusted_person=Trusted_person::create($data);
        
            return response()->json(['message' => 'Trusted person created successfully', 'name' => $trusted_person->name], 201, [], JSON_UNESCAPED_UNICODE);
        
        
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $trusted_person=Trusted_person::findOrFail($id);

        
         return new TrustedPersonResource($trusted_person);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrustedPersonRequest $request, Trusted_person $trusted_person)
    {
        //

        // $trusted_person->update($request->validated());
        $data = $request->validated();
        
        try{
            // // Проверяем, было ли загружено изображение
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

            Helper::processImage($request, $data);
            $trusted_person->update($data);
        return new TrustedPersonResource($trusted_person);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trusted_person $trusted_person)
    {
        //
        $trusted_person->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}