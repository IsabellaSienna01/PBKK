<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permissions
        $permissions = [
            'view-dashboard',
            'view-mahasiswa',
            'create-mahasiswa',
            'edit-mahasiswa',
            'delete-mahasiswa', // Hak Eksklusif Admin
            'view-matakuliah',
            'create-matakuliah',
            'edit-matakuliah',
            'delete-matakuliah', // Hak Eksklusif Admin
            'view-ide-agent',
            'delete-ide-agent', // Hak Eksklusif Admin
            'manage-users', // Hak Eksklusif Admin
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // 2. Buat Role 'Admin' (Akses Penuh) & berikan semua permissions
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $roleAdmin->syncPermissions(Permission::all());

        // 3. Buat Role 'Staf' (Akses Terbatas: tidak boleh delete data dan manage users)
        $roleStaf = Role::firstOrCreate(['name' => 'Staf', 'guard_name' => 'web']);
        $roleStaf->syncPermissions([
            'view-dashboard',
            'view-mahasiswa',
            'create-mahasiswa',
            'edit-mahasiswa',
            'view-matakuliah',
            'create-matakuliah',
            'edit-matakuliah',
            'view-ide-agent',
        ]);

        // 4. Buat Akun Pengguna Uji Coba (Auto-Login Test Accounts)

        // Akun Admin Utama
        $admin = User::firstOrCreate(
            ['email' => 'admin@academic.its.ac.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles([$roleAdmin]);

        // Akun Staf Akademik (Akses Terbatas)
        $staf = User::firstOrCreate(
            ['email' => 'staf@academic.its.ac.id'],
            [
                'name' => 'Staf Akademik',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $staf->syncRoles([$roleStaf]);

        // Akun Mahasiswa / Owner Portfolio (Admin)
        $owner = User::firstOrCreate(
            ['email' => 'isabella@student.its.ac.id'],
            [
                'name' => 'Isabella Sienna Sulisthio',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $owner->syncRoles([$roleAdmin]);
    }
}
