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
        $roles = ['admin', 'guest', 'citizen','teacher','finance'];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }

        $user = User::updateOrCreate([
            'login' => 'admin',
            'employee_id_number' => '1',
        ],[
            'email' => 'admin@buxdu.uz',
            'full_name' => 'Admin Admin Admin',
            'password' => 'admin'
        ]);

        $user->assignRole(['admin', 'guest', 'citizen','teacher','finance']);
    }
}
