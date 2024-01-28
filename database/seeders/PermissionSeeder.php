<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    private const ACTION_VIEW_ANY = 'viewAny';

    private const ACTION_VIEW = 'view';

    private const ACTION_CREATE = 'create';

    private const ACTION_UPDATE = 'update';

    private const ACTION_DELETE = 'delete';

    private const ACTION_MANAGE = 'manage';

    protected const ACTION_REVERT = 'revert';

    protected const ACTION_FORCE_DELETE = 'forceDelete';

    private const ACTIONS_MANAGE = [
        self::ACTION_MANAGE,
    ];

    private const ACTIONS_CRUD = [
        self::ACTION_VIEW_ANY,
        self::ACTION_VIEW,
        self::ACTION_CREATE,
        self::ACTION_UPDATE,
        self::ACTION_DELETE,
    ];

    protected array $permissions = [
        'users' => self::ACTIONS_CRUD,
    ];

    public function createPermissions()
    {
        collect($this->permissions)->map(function ($actions, $resource) {
            return collect($actions)->map(function ($action) use ($resource) {
                Permission::firstOrCreate(['name' => "$resource.$action"], ['guard_name' => 'web']);
            });
        });
    }

    public function run()
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->createPermissions();

        $adminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));
    }
}
