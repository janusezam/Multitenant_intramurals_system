@php
    $borderColor = $match->winner_id ? 'border-green-300' : 'border-gray-200';
    $teamAWinner = $match->winner_id === $match->team_a_id;
    $teamBWinner = $match->winner_id === $match->team_b_id;
@endphp

<div class="border rounded-lg p-3 bg-white shadow-sm {{ $borderColor }} min-w-44">
    <!-- Team A -->
    <div class="py-2 px-3 rounded @if($teamAWinner) bg-green-50 font-bold text-green-800 @elseif($match->winner_id) text-gray-400 @endif">
        {{ $match->teamA?->name ?? 'BYE' }}
        @if($teamAWinner)
            <span class="text-xs ml-1">🏆</span>
        @endif
    </div>

    <div class="border-t border-gray-200 my-1"></div>

    <!-- Team B -->
    <div class="py-2 px-3 rounded @if($teamBWinner) bg-green-50 font-bold text-green-800 @elseif($match->winner_id) text-gray-400 @endif">
        {{ $match->teamB?->name ?? 'BYE' }}
        @if($teamBWinner)
            <span class="text-xs ml-1">🏆</span>
        @endif
    </div>

    <!-- Winner Selection Form or Advances Message -->
    @if(!$match->winner_id && $match->teamA && $match->teamB)
        <div class="mt-2 border-t pt-2">
            <form method="POST" action="{{ route('tenant.brackets.updateMatch', [$university->slug, $match->id]) }}">
                @csrf
                @method('PATCH')
                <select name="winner_id" required class="w-full text-xs border border-gray-300 rounded p-1 mb-1">
                    <option value="">-- Select Winner --</option>
                    <option value="{{ $match->team_a_id }}">{{ $match->teamA->name }}</option>
                    <option value="{{ $match->team_b_id }}">{{ $match->teamB->name }}</option>
                </select>
                <button type="submit" class="w-full text-xs bg-indigo-600 text-white rounded py-1 hover:bg-indigo-700 font-medium">
                    ✓ Set Winner
                </button>
            </form>
        </div>
    @elseif($match->winner_id)
        <div class="mt-1 text-xs text-green-600 text-center font-medium">
            ✅ {{ $match->winner->name }} advances
        </div>
    @endif
</div>
