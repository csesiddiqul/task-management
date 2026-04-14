<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [
            'my-tasks',
            'task-list',
            'task-create',
            'task-edit',
            'task-delete',
            'manage-users'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

        
        $admin = Role::findOrCreate('admin', 'api');
        $admin->givePermissionTo(Permission::all());

        $member = Role::findOrCreate('member', 'api');
        $member->givePermissionTo(['task-list', 'task-edit']);
    }
}
