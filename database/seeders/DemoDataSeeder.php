<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Schedule;
use App\Models\Sport;
use App\Models\Team;
use App\Models\University;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get UST university
        $ust = University::where('slug', 'ust')->first();

        if (! $ust) {
            return;
        }

        // Create sports
        $basketball = Sport::firstOrCreate(
            [
                'university_id' => $ust->id,
                'name' => 'Basketball',
            ],
            [
                'category' => 'team',
                'bracket_type' => 'single_elimination',
                'status' => 'ongoing',
            ]
        );

        $volleyball = Sport::firstOrCreate(
            [
                'university_id' => $ust->id,
                'name' => 'Volleyball',
            ],
            [
                'category' => 'team',
                'bracket_type' => 'round_robin',
                'status' => 'upcoming',
            ]
        );

        $badminton = Sport::firstOrCreate(
            [
                'university_id' => $ust->id,
                'name' => 'Badminton',
            ],
            [
                'category' => 'individual',
                'bracket_type' => 'single_elimination',
                'status' => 'upcoming',
            ]
        );

        // Create venues
        $mainGym = Venue::firstOrCreate(
            [
                'university_id' => $ust->id,
                'name' => 'Main Gymnasium',
            ],
            [
                'location' => 'UST Main Campus',
                'capacity' => 500,
                'is_available' => true,
            ]
        );

        $courtA = Venue::firstOrCreate(
            [
                'university_id' => $ust->id,
                'name' => 'Covered Court A',
            ],
            [
                'location' => 'UST North Wing',
                'capacity' => 200,
                'is_available' => true,
            ]
        );

        $courtB = Venue::firstOrCreate(
            [
                'university_id' => $ust->id,
                'name' => 'Covered Court B',
            ],
            [
                'location' => 'UST South Wing',
                'capacity' => 200,
                'is_available' => true,
            ]
        );

        // Create teams
        $engTeam = Team::firstOrCreate(
            [
                'university_id' => $ust->id,
                'sport_id' => $basketball->id,
                'name' => 'College of Engineering',
            ],
            [
                'color' => '#FF0000',
                'status' => 'active',
            ]
        );

        $tourismTeam = Team::firstOrCreate(
            [
                'university_id' => $ust->id,
                'sport_id' => $basketball->id,
                'name' => 'College of Tourism',
            ],
            [
                'color' => '#0000FF',
                'status' => 'active',
            ]
        );

        $nursingTeam = Team::firstOrCreate(
            [
                'university_id' => $ust->id,
                'sport_id' => $basketball->id,
                'name' => 'College of Nursing',
            ],
            [
                'color' => '#00FF00',
                'status' => 'active',
            ]
        );

        $commerceTeam = Team::firstOrCreate(
            [
                'university_id' => $ust->id,
                'sport_id' => $basketball->id,
                'name' => 'College of Commerce',
            ],
            [
                'color' => '#FFFF00',
                'status' => 'active',
            ]
        );

        // Create student players
        $juan = User::firstOrCreate(
            ['email' => 'juan@ust.edu.ph'],
            [
                'name' => 'Juan Dela Cruz',
                'password' => bcrypt('password'),
                'university_id' => $ust->id,
                'student_id' => 'STU001',
            ]
        );
        $juan->assignRole('student-player');

        Player::firstOrCreate(
            [
                'university_id' => $ust->id,
                'user_id' => $juan->id,
                'team_id' => $engTeam->id,
            ],
            [
                'sport_id' => $basketball->id,
                'jersey_number' => '10',
                'position' => 'Point Guard',
                'status' => 'active',
            ]
        );

        $maria = User::firstOrCreate(
            ['email' => 'maria@ust.edu.ph'],
            [
                'name' => 'Maria Santos',
                'password' => bcrypt('password'),
                'university_id' => $ust->id,
                'student_id' => 'STU002',
            ]
        );
        $maria->assignRole('student-player');

        Player::firstOrCreate(
            [
                'university_id' => $ust->id,
                'user_id' => $maria->id,
                'team_id' => $tourismTeam->id,
            ],
            [
                'sport_id' => $basketball->id,
                'jersey_number' => '5',
                'position' => 'Shooting Guard',
                'status' => 'active',
            ]
        );

        $pedro = User::firstOrCreate(
            ['email' => 'pedro@ust.edu.ph'],
            [
                'name' => 'Pedro Reyes',
                'password' => bcrypt('password'),
                'university_id' => $ust->id,
                'student_id' => 'STU003',
            ]
        );
        $pedro->assignRole('student-player');

        Player::firstOrCreate(
            [
                'university_id' => $ust->id,
                'user_id' => $pedro->id,
                'team_id' => $nursingTeam->id,
            ],
            [
                'sport_id' => $basketball->id,
                'jersey_number' => '23',
                'position' => 'Center',
                'status' => 'active',
            ]
        );

        $ana = User::firstOrCreate(
            ['email' => 'ana@ust.edu.ph'],
            [
                'name' => 'Ana Lim',
                'password' => bcrypt('password'),
                'university_id' => $ust->id,
                'student_id' => 'STU004',
            ]
        );
        $ana->assignRole('student-player');

        Player::firstOrCreate(
            [
                'university_id' => $ust->id,
                'user_id' => $ana->id,
                'team_id' => $commerceTeam->id,
            ],
            [
                'sport_id' => $basketball->id,
                'jersey_number' => '7',
                'position' => 'Small Forward',
                'status' => 'active',
            ]
        );

        // Create sports facilitator
        $facilitator = User::firstOrCreate(
            ['email' => 'facilitator@ust.edu.ph'],
            [
                'name' => 'Coach Facilitator',
                'password' => bcrypt('password'),
                'university_id' => $ust->id,
            ]
        );
        $facilitator->assignRole('sports-facilitator');

        // Update basketball sport with facilitator
        $basketball->update([
            'facilitator_id' => $facilitator->id,
        ]);

        // Create schedules
        Schedule::firstOrCreate(
            [
                'university_id' => $ust->id,
                'sport_id' => $basketball->id,
                'home_team_id' => $engTeam->id,
                'away_team_id' => $tourismTeam->id,
                'scheduled_at' => Carbon::tomorrow()->setHour(10)->setMinute(0),
            ],
            [
                'venue_id' => $mainGym->id,
                'status' => 'scheduled',
            ]
        );

        Schedule::firstOrCreate(
            [
                'university_id' => $ust->id,
                'sport_id' => $basketball->id,
                'home_team_id' => $nursingTeam->id,
                'away_team_id' => $commerceTeam->id,
                'scheduled_at' => Carbon::tomorrow()->setHour(14)->setMinute(0),
            ],
            [
                'venue_id' => $courtA->id,
                'status' => 'scheduled',
            ]
        );
    }
}
