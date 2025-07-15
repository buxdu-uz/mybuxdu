<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'user', 'citizen'];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }

        $user = User::updateOrCreate([
            'login' => 'admin'
        ],[
            'name' => 'Admin',
            'password' => 'admin'
        ]);

        $user->assignRole(['admin','user', 'citizen']);
    }
}
