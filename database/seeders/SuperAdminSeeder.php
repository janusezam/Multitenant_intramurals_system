<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@isms.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password'),
                'university_id' => null,
            ]
        );

        $superAdmin->assignRole('super-admin');
    }
}
