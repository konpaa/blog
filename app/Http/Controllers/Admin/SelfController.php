<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;

class SelfController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }
}
