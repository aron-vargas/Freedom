<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $system_admin = User::factory()->create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'nickname' => 'Administrator',
            'email' => 'admin@noemail.com',
            'email_verified_at' => now(),
            'type' => UserType::User,
            'password' => Hash::make('adminpassword'), /* Reset this ASAP */
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $system_user = User::factory()->create([
            'first_name' => 'System',
            'last_name' => 'User',
            'nickname' => 'System User',
            'email' => 'systemuser@noemail.com',
            'email_verified_at' => now(),
            'type' => UserType::System,
            'password' => Hash::make('systempassword'), /* Reset this ASAP */
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // create permissions
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'edit permissions']);

        // create roles and assign permissions
        $SuperAdminRole = Role::create([
            'name' => 'Super-Admin',
            'description' => 'All permissions via Gate::before rule. see AuthServiceProvider',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $system_admin->assignRole($SuperAdminRole);

        $SystemUserRole = Role::create([
            'name' => 'System-User',
            'description' => 'Defined permissions for System administration.',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $SystemUserRole->givePermissionTo('edit users');
        $SystemUserRole->givePermissionTo('edit roles');
        $SystemUserRole->givePermissionTo('edit permissions');
        $system_user->assignRole($SystemUserRole);
    }
}
