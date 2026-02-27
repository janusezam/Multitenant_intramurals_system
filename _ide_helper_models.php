<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $sport_id
 * @property string $name
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BracketMatch> $matches
 * @property-read int|null $matches_count
 * @property-read \App\Models\Sport $sport
 * @property-read \App\Models\University $university
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bracket whereUpdatedAt($value)
 */
	class Bracket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $bracket_id
 * @property int|null $schedule_id
 * @property int $round
 * @property int $match_order
 * @property int|null $team_a_id
 * @property int|null $team_b_id
 * @property int|null $winner_id
 * @property int|null $next_match_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bracket $bracket
 * @property-read BracketMatch|null $nextMatch
 * @property-read \App\Models\Schedule|null $schedule
 * @property-read \App\Models\Team|null $teamA
 * @property-read \App\Models\Team|null $teamB
 * @property-read \App\Models\University $university
 * @property-read \App\Models\Team|null $winner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereBracketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereMatchOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereNextMatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereRound($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereTeamAId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereTeamBId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BracketMatch whereWinnerId($value)
 */
	class BracketMatch extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $schedule_id
 * @property int $home_score
 * @property int $away_score
 * @property int|null $winner_team_id
 * @property bool $is_draw
 * @property string|null $remarks
 * @property int|null $recorded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $recorder
 * @property-read \App\Models\Schedule $schedule
 * @property-read \App\Models\University $university
 * @property-read \App\Models\Team|null $winnerTeam
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereIsDraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatchResult whereWinnerTeamId($value)
 */
	class MatchResult extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $user_id
 * @property int $team_id
 * @property int $sport_id
 * @property string|null $jersey_number
 * @property string|null $position
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Sport $sport
 * @property-read \App\Models\Team $team
 * @property-read \App\Models\University $university
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereJerseyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereUserId($value)
 */
	class Player extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $sport_id
 * @property int|null $venue_id
 * @property int $home_team_id
 * @property int $away_team_id
 * @property \Illuminate\Support\Carbon $scheduled_at
 * @property string|null $notes
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $awayTeam
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BracketMatch> $bracketMatches
 * @property-read int|null $bracket_matches_count
 * @property-read \App\Models\Team $homeTeam
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MatchResult> $matchResult
 * @property-read int|null $match_result_count
 * @property-read \App\Models\Sport $sport
 * @property-read \App\Models\University $university
 * @property-read \App\Models\Venue|null $venue
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereAwayTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereHomeTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereVenueId($value)
 */
	class Schedule extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property string $name
 * @property string|null $description
 * @property string $category
 * @property string $bracket_type
 * @property int|null $facilitator_id
 * @property int $max_teams
 * @property string $status
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bracket> $brackets
 * @property-read int|null $brackets_count
 * @property-read \App\Models\User|null $facilitator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Standing> $standings
 * @property-read int|null $standings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \App\Models\University $university
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereBracketType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereFacilitatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereMaxTeams($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sport whereUpdatedAt($value)
 */
	class Sport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $sport_id
 * @property int $team_id
 * @property int $wins
 * @property int $losses
 * @property int $draws
 * @property int $points
 * @property int $goals_for
 * @property int $goals_against
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Sport $sport
 * @property-read \App\Models\Team $team
 * @property-read \App\Models\University $university
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereDraws($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereGoalsAgainst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereGoalsFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereLosses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Standing whereWins($value)
 */
	class Standing extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property string $plan
 * @property string $academic_year
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon $expires_at
 * @property numeric $amount_paid
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\University $university
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereAcademicYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property int $sport_id
 * @property string $name
 * @property int|null $coach_id
 * @property string|null $logo
 * @property string|null $color
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $awaySchedules
 * @property-read int|null $away_schedules_count
 * @property-read \App\Models\User|null $coach
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $homeSchedules
 * @property-read int|null $home_schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MatchResult> $matchResults
 * @property-read int|null $match_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \App\Models\Sport $sport
 * @property-read \App\Models\Standing|null $standing
 * @property-read \App\Models\University $university
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCoachId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereSportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string|null $address
 * @property string|null $logo
 * @property string $plan
 * @property \Illuminate\Support\Carbon|null $plan_expires_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BracketMatch> $bracketMatches
 * @property-read int|null $bracket_matches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bracket> $brackets
 * @property-read int|null $brackets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MatchResult> $matchResults
 * @property-read int|null $match_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sport> $sports
 * @property-read int|null $sports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Standing> $standings
 * @property-read int|null $standings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Venue> $venues
 * @property-read int|null $venues_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University wherePlanExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|University whereUpdatedAt($value)
 */
	class University extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $university_id
 * @property string|null $student_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $profile_photo
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $coachedTeams
 * @property-read int|null $coached_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sport> $facilitatedSports
 * @property-read int|null $facilitated_sports_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MatchResult> $recordedResults
 * @property-read int|null $recorded_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\University|null $university
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $university_id
 * @property string $name
 * @property string|null $description
 * @property string|null $location
 * @property int|null $capacity
 * @property bool $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $schedules
 * @property-read int|null $schedules_count
 * @property-read \App\Models\University $university
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venue whereUpdatedAt($value)
 */
	class Venue extends \Eloquent {}
}

