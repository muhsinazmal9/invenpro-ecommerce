<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();
        $permissionNames = $permissions->pluck('name');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'customer']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($permissionNames);

        $user = User::find(1);
        $user->assignRole(['super_admin']);

        $user = User::find(2);
        $user->assignRole(['manager']);

        $user = User::find(3);
        $user->assignRole(['editor']);

        $user = User::find(4);
        $user->assignRole(['customer']);
    }
}
