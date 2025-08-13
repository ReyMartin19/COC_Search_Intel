<div class="mb-6">
    <h3 class="text-lg font-semibold text-white mb-3">{{ $war['opponent']['name'] ?? 'Opponent' }} Members</h3>
    <div class="overflow-x-auto rounded-md ring-1 ring-white/10 bg-gray-900/30">
        <table class="min-w-full text-sm text-gray-300">
            <thead>
                <tr class="bg-gray-800/70">
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">TH Level</th>
                    <th class="px-4 py-2 text-left">Map Position</th>
                    <th class="px-4 py-2 text-left">Attacks</th>
                    <th class="px-4 py-2 text-left">Stars Earned</th>
                    <th class="px-4 py-2 text-left">Destruction</th>
                    <th class="px-4 py-2 text-left">Opponent Attacks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($war['opponent']['members'] ?? [] as $member)
                    <tr class="border-b border-gray-700/60 hover:bg-gray-800/40 transition">
                        <td class="px-4 py-2">{{ $member['name'] ?? 'Unknown' }}</td>
                        <td class="px-4 py-2">{{ $member['townhallLevel'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $member['mapPosition'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ count($member['attacks'] ?? []) }}</td>
                        <td class="px-4 py-2">
                            @foreach ($member['attacks'] ?? [] as $attack)
                                {{ $attack['stars'] }}★ vs {{ $attack['defenderTag'] }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                            @foreach ($member['attacks'] ?? [] as $attack)
                                {{ $attack['destructionPercentage'] }}% ({{ $attack['duration'] }}s)<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                            @if (isset($member['bestOpponentAttack']))
                                {{ $member['bestOpponentAttack']['stars'] }}★ ({{ $member['bestOpponentAttack']['destructionPercentage'] }}%) by {{ $member['bestOpponentAttack']['attackerTag'] }}
                            @else
                                None
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>