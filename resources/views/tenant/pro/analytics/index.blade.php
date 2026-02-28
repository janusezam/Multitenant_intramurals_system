@extends('layouts.app')
@section('title', 'Analytics & Reports')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-gray-900">Analytics & Reports 📊</h1>
            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded">
                ⭐ PRO PLAN FEATURE
            </span>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('tenant.analytics.exportPdf', $university->slug) }}" target="_blank" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium flex items-center gap-2">
                📄 Export PDF
            </a>
            <a href="{{ route('tenant.analytics.exportExcel', $university->slug) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium flex items-center gap-2">
                📊 Export Excel
            </a>
        </div>
    </div>

    <!-- Section 1: Game Stats Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @include('tenant.pro.analytics._partials.stat_card', [
            'icon' => '✅',
            'label' => 'Games Played',
            'value' => $gameStats['completed'] ?? 0,
            'color' => 'green'
        ])

        @include('tenant.pro.analytics._partials.stat_card', [
            'icon' => '📅',
            'label' => 'Games Scheduled',
            'value' => $gameStats['scheduled'] ?? 0,
            'color' => 'blue'
        ])

        @include('tenant.pro.analytics._partials.stat_card', [
            'icon' => '❌',
            'label' => 'Games Cancelled',
            'value' => $gameStats['cancelled'] ?? 0,
            'color' => 'red'
        ])

        @include('tenant.pro.analytics._partials.stat_card', [
            'icon' => '🎯',
            'label' => 'Total Games',
            'value' => ($gameStats['completed'] ?? 0) + ($gameStats['scheduled'] ?? 0) + ($gameStats['cancelled'] ?? 0),
            'color' => 'indigo'
        ])
    </div>

    <!-- Section 2: Chart Row (2 Charts Side by Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Teams per Sport Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Teams per Sport</h2>
            <canvas id="teamsPerSportChart" style="height: 300px;"></canvas>
        </div>

        <!-- Players per Sport Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Players per Sport</h2>
            <canvas id="playersPerSportChart" style="height: 300px;"></canvas>
        </div>
    </div>

    <!-- Section 3: Venue Utilization Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Venue Utilization 🏟️</h2>
        <canvas id="venueChart" style="height: 250px;"></canvas>
    </div>

    <!-- Section 4: Top Performing Teams Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Top Performing Teams 🏆</h2>
        </div>

        @if($topPerformers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Team Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">W</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">L</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">D</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Pts</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($topPerformers as $index => $performer)
                            @php
                                $rank = $index + 1;
                                $rankDisplay = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : $rank));
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $rankDisplay }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $performer->team->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ $performer->team->sport->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-green-600">
                                    {{ $performer->wins }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-red-600">
                                    {{ $performer->losses }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-gray-600">
                                    {{ $performer->draws }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-indigo-600">
                                    {{ $performer->points }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center text-gray-500">
                No standings data yet.
            </div>
        @endif
    </div>

    <!-- Section 5: Sports Overview Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Sports Overview 📋</h2>
        </div>

        @if($sports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Teams</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Players</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Schedules</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Facilitator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($sports as $sport)
                            @php
                                $statusColors = [
                                    'upcoming' => 'bg-blue-100 text-blue-800',
                                    'ongoing' => 'bg-green-100 text-green-800',
                                    'completed' => 'bg-gray-100 text-gray-800',
                                ];
                                $statusColor = $statusColors[$sport->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $sport->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ ucfirst($sport->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block {{ $statusColor }} text-xs font-semibold px-2 py-1 rounded">
                                        {{ ucfirst($sport->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-900 font-medium">
                                    {{ $sport->teams_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-900 font-medium">
                                    {{ $sport->players_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-900 font-medium">
                                    {{ $sport->schedules_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    @if($sport->facilitator)
                                        {{ $sport->facilitator->name }}
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center text-gray-500">
                No sports added yet.
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Teams per Sport Chart
    const teamsChart = new Chart(
        document.getElementById('teamsPerSportChart'),
        {
            type: 'bar',
            data: {
                labels: @json($chartData['sport_labels'] ?? []),
                datasets: [{
                    label: 'Teams',
                    data: @json($chartData['team_counts'] ?? []),
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        }
    );

    // Players per Sport Chart
    const playersChart = new Chart(
        document.getElementById('playersPerSportChart'),
        {
            type: 'bar',
            data: {
                labels: @json($chartData['sport_labels'] ?? []),
                datasets: [{
                    label: 'Players',
                    data: @json($chartData['player_counts'] ?? []),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        }
    );

    // Venue Utilization Chart
    const venueChart = new Chart(
        document.getElementById('venueChart'),
        {
            type: 'doughnut',
            data: {
                labels: @json($chartData['venue_labels'] ?? []),
                datasets: [{
                    data: @json($chartData['venue_counts'] ?? []),
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        }
    );
</script>
@endpush
