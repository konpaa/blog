<?php

namespace Database\Seeders\Demo;

use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User as AuthUser;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(['email' => 'user@email.by'], [
            'name' => 'Admin',
            'password' => 'qwerty',
            'email' => 'user@email.by',
            'email_verified_at' => now(),
        ]);

        $user->roles()->sync(Role::findByName('Super Admin'));

        DB::table('personal_access_tokens')->updateOrInsert([
            'tokenable_type' => AuthUser::class,
            'tokenable_id' => $user->id,
            'name' => 'postman',
        ], [
            'id' => 1,
            'tokenable_type' => AuthUser::class,
            'tokenable_id' => $user->id,
            'name' => 'postman',
            'token' => '0d21483d1079804ac11c694eb22ef69ecae27cb9a15797a3349cf01f4e2946e6', // 1|ED4IJWDoJGY44nmJJbY3KA5gx8hqSgCtYs3h3sD8
            'abilities' => '["*"]',
        ]);
    }
}
