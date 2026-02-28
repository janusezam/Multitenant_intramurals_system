<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report - {{ $university->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            background: #1e3a5f;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
        }

        h2 {
            color: #1e3a5f;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 8px;
            margin-top: 20px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #1e3a5f;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1e3a5f;
            font-size: 11px;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-red {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .badge-indigo {
            background: #e0e7ff;
            color: #312e81;
        }

        .badge-purple {
            background: #ede9fe;
            color: #4c1d95;
        }

        .badge-amber {
            background: #fef3c7;
            color: #78350f;
        }

        .stat-cards {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .stat-card {
            display: inline-block;
            border: 1px solid #ddd;
            padding: 10px;
            min-width: 100px;
            text-align: center;
            background: #f9f9f9;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a5f;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #999;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🏆 ISMS Analytics Report</h1>
        <p><strong>{{ $university->name }}</strong></p>
        <p>Generated: {{ now()->format('F d, Y') }}</p>
        <p>Plan: {{ ucfirst($university->plan) }}</p>
    </div>

    <!-- Game Stats -->
    <h2>Game Statistics</h2>
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-value">{{ $gameStats['completed'] ?? 0 }}</div>
            <div class="stat-label">Games Played</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $gameStats['scheduled'] ?? 0 }}</div>
            <div class="stat-label">Games Scheduled</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $gameStats['cancelled'] ?? 0 }}</div>
            <div class="stat-label">Games Cancelled</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ ($gameStats['completed'] ?? 0) + ($gameStats['scheduled'] ?? 0) + ($gameStats['cancelled'] ?? 0) }}</div>
            <div class="stat-label">Total Games</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Games Played</th>
                <th>Games Scheduled</th>
                <th>Games Cancelled</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $gameStats['completed'] ?? 0 }}</td>
                <td>{{ $gameStats['scheduled'] ?? 0 }}</td>
                <td>{{ $gameStats['cancelled'] ?? 0 }}</td>
                <td><strong>{{ ($gameStats['completed'] ?? 0) + ($gameStats['scheduled'] ?? 0) + ($gameStats['cancelled'] ?? 0) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Top Performers -->
    <h2>Top Performing Teams</h2>
    @if($topPerformers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Team</th>
                    <th>Sport</th>
                    <th>W</th>
                    <th>L</th>
                    <th>D</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topPerformers as $index => $performer)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>{{ $performer->team->name }}</td>
                        <td><span class="badge badge-indigo">{{ $performer->team->sport->name }}</span></td>
                        <td><strong>{{ $performer->wins }}</strong></td>
                        <td><strong>{{ $performer->losses }}</strong></td>
                        <td><strong>{{ $performer->draws }}</strong></td>
                        <td><strong>{{ $performer->points }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No standings data yet.</p>
    @endif

    <!-- Sports Overview -->
    <h2>Sports Overview</h2>
    @if($sports->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Sport</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Teams</th>
                    <th>Players</th>
                    <th>Schedules</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sports as $sport)
                    <tr>
                        <td><strong>{{ $sport->name }}</strong></td>
                        <td><span class="badge badge-purple">{{ ucfirst($sport->category) }}</span></td>
                        <td>
                            @if($sport->status === 'upcoming')
                                <span class="badge badge-blue">{{ ucfirst($sport->status) }}</span>
                            @elseif($sport->status === 'ongoing')
                                <span class="badge badge-green">{{ ucfirst($sport->status) }}</span>
                            @else
                                <span class="badge">{{ ucfirst($sport->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $sport->teams_count ?? 0 }}</td>
                        <td>{{ $sport->players_count ?? 0 }}</td>
                        <td>{{ $sport->schedules_count ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No sports added yet.</p>
    @endif

    <!-- Venues -->
    <h2>Venues</h2>
    @if($venues && $venues->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Games Scheduled</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venues as $venue)
                    <tr>
                        <td><strong>{{ $venue->name }}</strong></td>
                        <td>{{ $venue->location ?? '—' }}</td>
                        <td>{{ $venue->capacity ?? '—' }}</td>
                        <td>{{ $venue->schedules_count ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No venues added yet.</p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Generated by ISMS · {{ now()->format('Y') }}</p>
    </div>
</body>
</html>
