<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamilyAccountResource;
use App\Http\Resources\FamilyMobileResource;
use App\Http\Resources\CommentResource;
use App\Models\Family_account;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\FamilyAccountRequest;
use App\Http\Requests\ParentEmailRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendParentNotification;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use App\Models\Comment;
use App\Models\Child_profile;

class Family_accountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return FamilyAccountResource::collection(Family_account::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeComment(CommentRequest $request)
    {
        $data = $request->validated();
        $comment = Comment::create($data);

    return response()->json(['message' => 'Comment sent'], 200);
    }

    public function indexComment()
    {

    return CommentResource::collection(Comment::all());
    }
    /**
     * Display the specified resource.
     */
    public function show(Family_account $family_account)
    {
        
        return new FamilyAccountResource($family_account);
    }

    public function showForMobile(Family_account $family_account)
    {
        return new FamilyMobileResource($family_account);
    }


    public function sendParentEmail(ParentEmailRequest $request){

        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();
        $data['name'] = $user->name;

        Notification::route('mail', $data['email'])
                ->notify(new SendParentNotification($data['name'], $data['text_email'] ));

                return response()->json(['message' => 'Notification sent'], 200);
    }


public function getFamilyAccountIdsByGroup($groupId) 
{
    $children = Child_profile::where('group_id', $groupId)->get();

    $familyAccounts = collect();

    foreach ($children as $child) {
        $familyAccount = $child->family_account ;
        $familyAccounts->push([
            'id' => $familyAccount->id,
            'name' => $familyAccount->user->name,
            'email' => $familyAccount->user->email,
        ]);
    }

    return $familyAccounts->unique()->values()->all();
}


    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyAccountRequest $request, Family_account $family_account)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        

        if (!$user->hasRole('admin') &&  $user->id !== $family_account->user_id) {
            return response()->json(['error' => 'You are not authorized to update this profile'], 403);
        }
          
        $data = $request->validated();
        try{

            Helper::processBase64Image($request, $data);

        $family_account->update($data);

        return new FamilyAccountResource($family_account);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family_account $family_account)
    {
        //
        $family_account->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
