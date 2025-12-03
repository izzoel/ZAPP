<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role sudah ada (dipanggil dari RolePermissionSeeder)
        // $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        // $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // // Buat atau update Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('nimda'), // ganti sesuai kebutuhan
                'avatar' => rand(0,11).'.png',
            ],
        );
        // $admin->syncRoles([$adminRole]); // assign role admin

        // Buat atau update User biasa
        $user = User::updateOrCreate(
            ['email' => 'user@mail.com'],
            [
                'name' => 'user',
                'password' => bcrypt('resu'), // ganti sesuai kebutuhan
                'avatar' => rand(0,11).'.png',
            ],
        );
        // $user->syncRoles([$userRole]); // assign role user
    }
}
