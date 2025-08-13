<div class="mt-6">
    <h3 class="text-lg font-bold text-gray-200 mb-4">War Map</h3>
    @if (!empty($war['clan']['members']) && !empty($war['opponent']['members']))
        <div class="space-y-6">
            @foreach($war['clan']['members'] as $index => $homePlayer)
                @php
                    $awayPlayer = $war['opponent']['members'][$index] ?? [];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-800/50 rounded-lg p-4 border border-gray-700 hover:border-purple-500/30 transition-all duration-300">
                    @include('clan.partials.war-tab.war-member', [
                        'player' => $homePlayer,
                        'opponentPlayer' => $awayPlayer,
                        'defenderNames' => $defenderNames,
                        'isHome' => true
                    ])
                    @include('clan.partials.war-tab.war-member', [
                        'player' => $awayPlayer,
                        'opponentPlayer' => $homePlayer,
                        'defenderNames' => $defenderNames,
                        'isHome' => false
                    ])
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-400 py-4">No war members data available</div>
    @endif
</div>