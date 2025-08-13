<div>
    <!-- Player Header -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
            <!-- Player Map Position -->
            <span class="bg-purple-500/20 text-purple-300 text-xs font-bold px-2 py-1 rounded-full">
                #{{ $player['mapPosition'] ?? 'N/A' }}
            </span>
            <span class="text-white font-medium">{{ $player['name'] ?? 'Unknown' }}</span>
            <span class="text-gray-400 text-xs">{{ $player['tag'] ?? '' }}</span>
        </div>
        <span class="text-white text-sm">TH{{ $player['townhallLevel'] ?? 'N/A' }}</span>
    </div>

    <!-- Attacks Section -->
    <div class="bg-gray-700/30 rounded-lg p-3 mb-3">
        <div class="flex justify-between items-center mb-2">
            <h4 class="text-white font-medium text-sm">Attacks</h4>
            <span class="text-xs {{ isset($player['attacks']) && count($player['attacks']) > 0 ? 'text-yellow-400' : 'text-green-400' }}">
                {{ count($player['attacks'] ?? []) }}/{{ $war['attacksPerMember'] ?? 0 }}
            </span>
        </div>
        @if(isset($player['attacks']) && count($player['attacks']) > 0)
            <div class="space-y-2">
                @foreach($player['attacks'] as $attack)
                    <div class="flex items-center justify-between text-xs bg-gray-700/50 p-2 rounded">
                        <span class="text-gray-300 truncate">
                            vs <span class="text-purple-300 font-bold">#{{ $opponentPlayer['mapPosition'] ?? '?' }}</span>
                            {{ $defenderNames[$attack['defenderTag'] ?? ''] ?? ($attack['defenderTag'] ?? 'Unknown') }}
                        </span>
                        <div class="flex items-center">
                            @for($i = 0; $i < ($attack['stars'] ?? 0); $i++)
                                <span class="material-symbols-outlined text-yellow-400 text-xs">star</span>
                            @endfor
                            @for($i = 0; $i < 3 - ($attack['stars'] ?? 0); $i++)
                                <span class="material-symbols-outlined text-gray-600 text-xs">star</span>
                            @endfor
                            <span class="ml-1 text-white">{{ $attack['destructionPercentage'] ?? 0 }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-400 text-xs text-center py-2">No attacks yet</div>
        @endif
    </div>

    <!-- Defenses Section -->
    <div class="bg-gray-700/30 rounded-lg p-3">
        <div class="flex justify-between items-center mb-2">
            <h4 class="text-white font-medium text-sm">Defenses</h4>
            <span class="text-xs {{ isset($player['opponentAttacks']) && $player['opponentAttacks'] > 0 ? 'text-red-400' : 'text-green-400' }}">
                {{ $player['opponentAttacks'] ?? 0 }} attacks
            </span>
        </div>
        @if(isset($player['bestOpponentAttack']))
            <div class="text-xs bg-gray-700/50 p-2 rounded">
                <div class="text-gray-300">Best attack:</div>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-white">
                        from <span class="text-purple-300 font-bold">#{{ $opponentPlayer['mapPosition'] ?? '?' }}</span>
                        {{ $defenderNames[$player['bestOpponentAttack']['attackerTag'] ?? ''] ?? ($player['bestOpponentAttack']['attackerTag'] ?? 'Unknown') }}
                    </span>
                    <div class="flex items-center">
                        @for($i = 0; $i < ($player['bestOpponentAttack']['stars'] ?? 0); $i++)
                            <span class="material-symbols-outlined text-yellow-400 text-xs">star</span>
                        @endfor
                        @for($i = 0; $i < 3 - ($player['bestOpponentAttack']['stars'] ?? 0); $i++)
                            <span class="material-symbols-outlined text-gray-600 text-xs">star</span>
                        @endfor
                        <span class="ml-1 text-white">{{ $player['bestOpponentAttack']['destructionPercentage'] ?? 0 }}%</span>
                    </div>
                </div>
            </div>
        @else
            <div class="text-gray-400 text-xs text-center py-2">No defenses yet</div>
        @endif
    </div>
</div>
