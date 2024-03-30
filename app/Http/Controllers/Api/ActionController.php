<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Action;
use Illuminate\Http\Request;
use App\Http\Resources\ActionResource;
use Illuminate\Http\Response;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        return ActionResource::collection(Action::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        try{
        $created_action = Action::create($validatedData);

        return response()->json($created_action, 201);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Action $action)
    {
        return new ActionResource($action);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $action = Action::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try{
        $action->update($validatedData);
        
        return response()->json($action, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        // $group->lessons()->delete(); 

        // // Удаление группы после удаления уроков
        // $group->delete();
    
        $action->lessons()->delete(); 


        $action->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
