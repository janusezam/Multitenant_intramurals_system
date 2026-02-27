<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            // University Management
            'manage universities',
            'view universities',

            // Sports Management
            'manage sports',
            'view sports',

            // Venue Management
            'manage venues',
            'view venues',

            // Team Management
            'manage teams',
            'view teams',

            // Player Management
            'manage players',
            'view players',

            // Schedule Management
            'manage schedules',
            'view schedules',

            // Results Management
            'manage results',
            'view results',

            // Standings
            'view standings',

            // Pro Features
            'view analytics',
            'manage brackets',
            'view brackets',
            'export reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $universityAdmin = Role::firstOrCreate(['name' => 'university-admin']);
        $eventOrganizer = Role::firstOrCreate(['name' => 'event-organizer']);
        $sportsFacilitator = Role::firstOrCreate(['name' => 'sports-facilitator']);
        $teamCoach = Role::firstOrCreate(['name' => 'team-coach']);
        $studentPlayer = Role::firstOrCreate(['name' => 'student-player']);

        // Assign permissions to super-admin (all permissions)
        $superAdmin->syncPermissions(Permission::all());

        // Assign permissions to university-admin (all except manage universities)
        $universityAdmin->syncPermissions(
            Permission::whereNotIn('name', ['manage universities'])->pluck('name')
        );

        // Assign permissions to event-organizer
        $eventOrganizer->syncPermissions([
            'manage sports',
            'view venues',
            'manage schedules',
            'view teams',
            'view players',
            'view results',
            'view standings',
            'view analytics',
            'view brackets',
        ]);

        // Assign permissions to sports-facilitator
        $sportsFacilitator->syncPermissions([
            'view sports',
            'view venues',
            'manage teams',
            'manage players',
            'manage schedules',
            'manage results',
            'view standings',
            'manage brackets',
        ]);

        // Assign permissions to team-coach
        $teamCoach->syncPermissions([
            'view sports',
            'view venues',
            'view teams',
            'manage players',
            'view schedules',
            'view results',
            'view standings',
        ]);

        // Assign permissions to student-player
        $studentPlayer->syncPermissions([
            'view sports',
            'view venues',
            'view teams',
            'view schedules',
            'view results',
            'view standings',
        ]);
    }
}
