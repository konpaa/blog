<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\UpdateRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function self(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function update(UpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());

        return new UserResource($user);
    }
}
