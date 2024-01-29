<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProfileImageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\FilesRequest;
use App\Http\Requests\Api\Profile\UpdateRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function self(Request $request)
    {
        $user = $request->user();
        $user->load('media');

        return new UserResource($user);
    }

    public function update(UpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function uploadFiles(FilesRequest $request)
    {
        $user = $request->user();
        $user->addMediaFromRequest('preview')->toMediaCollection(ProfileImageType::PREVIEW->value);
        if ($request->has('addition_files')) {
            $user
                ->addMultipleMediaFromRequest(['addition_files'])
                ->each(fn($file) => $file->toMediaCollection(ProfileImageType::ADDITION->value));
        }

        $user->load('media');
        return new UserResource($user);
    }

    public function deleteFiles(Request $request, $id)
    {
        $user = $request->user();
        $user->media()->findOrFail($id)->delete();
        $user->load('media');
        return new UserResource($user);
    }
}
