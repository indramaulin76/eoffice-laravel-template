<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionFixSeeder extends Seeder
{
    public function run(): void
    {
        // Create basic permissions
        $permissions = [
            'lihat surat',
            'buat surat', 
            'edit surat',
            'hapus surat',
            'buat rapat',
            'buat sppd',
            'revisi',
            'buat arsip surat'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create basic role for all users
        $userRole = Role::firstOrCreate(['name' => 'User']);
        
        // Give basic permissions to User role
        $userRole->syncPermissions([
            'lihat surat', 
            'buat surat', 
            'edit surat', 
            'hapus surat'
        ]);

        // Assign User role to all users who don't have roles
        $usersWithoutRoles = User::doesntHave('roles')->get();
        foreach ($usersWithoutRoles as $user) {
            $user->assignRole('User');
        }
    }
}
