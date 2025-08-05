<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'employer']);
        $user = Role::create(['name' => 'recruiter']);
        $candidate = Role::create(['name' => 'candidate']);

        // Create permissions
        $permissions = [
            'create roles',
            'edit roles',
            'delete roles',
            'assign permissions',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to super-admin
        $superAdmin->givePermissionTo(Permission::all());

        // Create Super Admin user
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('super-admin');

        //Create Admin user
        $admin = User::create([
            'name' => 'Recruiter User',
            'email' => 'recruiter@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('recruiter');

        // Create Normal user
        $normalUser = User::create([
            'name' => 'Employer User',
            'email' => 'employer@example.com',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole('employer');
        
        // Create Candidate user
        $normalUser = User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@example.com',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole('candidate');
    }
}
