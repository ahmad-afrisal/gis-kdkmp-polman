<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
     public function run(): void
    {
        // PENTING: Bersihkan cache permission di awal
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Mendefinisikan daftar permission yang akan dibuat

        $permissions = [
            'view business-assistant',
            'create business-assistant',
            'edit business-assistant',
            'delete business-assistant',
            'view cooperations',
            'create cooperations',
            'edit cooperations',

        ];

        // 2. Membuat permission satu per satu ke database
        foreach ($permissions as $permission) {
            // Gunakan firstOrCreate untuk menghindari error jika data sudah ada
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Membuat role 'admin'
        $adminRole = Role::create(['name' => 'admin','guard_name' => 'web']);
        $baRole = Role::create(['name' => 'bussiness-assistant','guard_name' => 'web']);

        // Memberikan permission kepada role 'admin'
        $adminRole->syncPermissions($permissions); #1

        // $baRole->givePermissionTo([
        //     'view my-lands',
        //     'create my-lands',
        //     'edit my-lands',
        //     'delete my-lands',
        // ]); #2

        // Membuat data user superadmin
        // $user = User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('password'),
        // ]);

        // Menetapkan role 'teacher' kepada user superadmin
        // $user->assignRole($adminRole);
    }
}
