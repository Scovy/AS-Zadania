<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('nazwa', 'admin')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@jobportal.pl'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('admin123'),
                    'role_id' => $adminRole->id,
                    'aktywny' => true,
                ]
            );
        }
    }
}
