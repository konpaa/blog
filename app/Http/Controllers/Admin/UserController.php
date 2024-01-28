<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.viewAny')->only('index');
        $this->middleware('can:users.view')->only('show');
    }

    public function query()
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::scope('search', 'scoutSearch'),
            ])
            ->allowedIncludes([
                //
            ]);
    }

    public function index(Request $request)
    {
        $query = $this->query();

        return UserResource::collection($query->paginate());
    }

    public function show(User $user)
    {
        $user->load('roles');
        return new UserResource($user);
    }
}
