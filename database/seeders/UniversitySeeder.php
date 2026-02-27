<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\University;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // UST (Pro Plan)
        $ust = University::firstOrCreate(
            ['slug' => 'ust'],
            [
                'name' => 'University of Santo Tomas',
                'email' => 'admin@ust.edu.ph',
                'plan' => 'pro',
                'is_active' => true,
                'plan_expires_at' => Carbon::now()->addYear(),
            ]
        );

        $ustAdmin = User::firstOrCreate(
            ['email' => 'admin@ust.edu.ph'],
            [
                'name' => 'UST Administrator',
                'password' => bcrypt('password'),
                'university_id' => $ust->id,
            ]
        );
        $ustAdmin->assignRole('university-admin');

        Subscription::firstOrCreate(
            [
                'university_id' => $ust->id,
                'academic_year' => '2025-2026',
            ],
            [
                'plan' => 'pro',
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addYear(),
                'amount_paid' => 0.00,
                'status' => 'active',
            ]
        );

        // DLSU (Basic Plan)
        $dlsu = University::firstOrCreate(
            ['slug' => 'dlsu'],
            [
                'name' => 'De La Salle University',
                'email' => 'admin@dlsu.edu.ph',
                'plan' => 'basic',
                'is_active' => true,
                'plan_expires_at' => Carbon::now()->addYear(),
            ]
        );

        $dlsuAdmin = User::firstOrCreate(
            ['email' => 'admin@dlsu.edu.ph'],
            [
                'name' => 'DLSU Administrator',
                'password' => bcrypt('password'),
                'university_id' => $dlsu->id,
            ]
        );
        $dlsuAdmin->assignRole('university-admin');

        Subscription::firstOrCreate(
            [
                'university_id' => $dlsu->id,
                'academic_year' => '2025-2026',
            ],
            [
                'plan' => 'basic',
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addYear(),
                'amount_paid' => 0.00,
                'status' => 'active',
            ]
        );

        // ADMU (Pro Plan)
        $admu = University::firstOrCreate(
            ['slug' => 'admu'],
            [
                'name' => 'Ateneo de Manila University',
                'email' => 'admin@admu.edu.ph',
                'plan' => 'pro',
                'is_active' => true,
                'plan_expires_at' => Carbon::now()->addYear(),
            ]
        );

        $admuAdmin = User::firstOrCreate(
            ['email' => 'admin@admu.edu.ph'],
            [
                'name' => 'ADMU Administrator',
                'password' => bcrypt('password'),
                'university_id' => $admu->id,
            ]
        );
        $admuAdmin->assignRole('university-admin');

        Subscription::firstOrCreate(
            [
                'university_id' => $admu->id,
                'academic_year' => '2025-2026',
            ],
            [
                'plan' => 'pro',
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addYear(),
                'amount_paid' => 0.00,
                'status' => 'active',
            ]
        );
    }
}
