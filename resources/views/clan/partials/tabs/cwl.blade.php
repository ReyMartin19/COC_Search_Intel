@php
    $minTH = 9;
    $maxTH = 17;

    // Early return if no CWL data is available
    if (!isset($clan['cwlGroup']) || empty($clan['cwlGroup']['clans'])) {
        echo '<div class="text-center py-8 text-gray-400">
                <span class="material-symbols-outlined text-blue-400 mr-2">info</span>
                CWL data is not available. CWL only appears during specific seasons.
              </div>';
        return;
    }

    $cwlGroup = $clan['cwlGroup'];
    $clanTHCounts = [];

    // Collect war data for each clan
    $clanWarStats = [];
    if (isset($clan['cwl']['wars']) && is_array($clan['cwl']['wars'])) {
        foreach ($clan['cwl']['wars'] as $war) {
            if ($war && isset($war['clan'], $war['opponent'])) {
                $clanTag = $war['clan']['tag'] ?? null;
                $opponentTag = $war['opponent']['tag'] ?? null;
                
                if ($clanTag) {
                    $clanWarStats[$clanTag] = [
                        'stars' => ($clanWarStats[$clanTag]['stars'] ?? 0) + ($war['clan']['stars'] ?? 0),
                        'destruction' => ($clanWarStats[$clanTag]['destruction'] ?? 0) + ($war['clan']['destructionPercentage'] ?? 0),
                        'warCount' => ($clanWarStats[$clanTag]['warCount'] ?? 0) + 1
                    ];
                }
                if ($opponentTag) {
                    $clanWarStats[$opponentTag] = [
                        'stars' => ($clanWarStats[$opponentTag]['stars'] ?? 0) + ($war['opponent']['stars'] ?? 0),
                        'destruction' => ($clanWarStats[$opponentTag]['destruction'] ?? 0) + ($war['opponent']['destructionPercentage'] ?? 0),
                        'warCount' => ($clanWarStats[$opponentTag]['warCount'] ?? 0) + 1
                    ];
                }
            }
        }
    }

    // Build each clan's TH count and stats
    foreach ($cwlGroup['clans'] as $cwlClan) {
        if (!isset($cwlClan['members']) || !is_array($cwlClan['members'])) {
            continue;
        }

        $tag = $cwlClan['tag'] ?? '';
        $name = $cwlClan['name'] ?? 'Unknown';
        $badge = $cwlClan['badgeUrls']['small'] ?? '';
        $thCounts = [];

        foreach ($cwlClan['members'] as $member) {
            $th = $member['townHallLevel'] ?? 0;
            if ($th >= $minTH && $th <= $maxTH) {
                $thCounts[$th] = ($thCounts[$th] ?? 0) + 1;
            }
        }

        // Fill missing THs
        for ($i = $minTH; $i <= $maxTH; $i++) {
            if (!isset($thCounts[$i])) $thCounts[$i] = 0;
        }

        krsort($thCounts); // Sort TH from high to low

        $clanTHCounts[] = [
            'name' => $name,
            'badge' => $badge,
            'counts' => $thCounts,
            'warStats' => $clanWarStats[$tag] ?? [
                'stars' => 0,
                'destruction' => 0,
                'warCount' => 0
            ],
        ];
    }

    // Sort strictly by stars (no destruction tie-breaker)
    usort($clanTHCounts, function ($a, $b) {
        $aStars = $a['warStats']['stars'] ?? 0;
        $bStars = $b['warStats']['stars'] ?? 0;

        if ($aStars !== $bStars) {
            return $bStars <=> $aStars; // Descending stars
        }

        // Deterministic tie-breaker by clan name (optional)
        $aName = $a['name'] ?? '';
        $bName = $b['name'] ?? '';
        return strcasecmp($aName, $bName);
    });
@endphp

{{-- CWL Rounds Tabs --}}
@if (!empty($clan['cwl']['rounds']))
    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-6 shadow-lg shadow-black/30 mt-8 mb-8">
        <div class="absolute -top-12 -left-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
        <h3 class="text-xl font-bold text-center text-white mb-4">CWL Rounds</h3>
        
        {{-- Round Tabs --}}
        <div class="flex flex-wrap justify-center gap-2 mb-6" id="cwl-round-tabs">
            @foreach ($clan['cwl']['rounds'] as $index => $round)
                <button 
                    class="cwl-round-btn px-5 py-2 rounded-4xl text-white ring-1 ring-white/10 transition-all
                           {{ $loop->first ? 'bg-blue-600' : 'bg-gray-800/50 hover:bg-blue-600' }}"
                    data-round="{{ $index }}">
                    Round {{ $index + 1 }}
                </button>
            @endforeach
        </div>

        {{-- Round Content --}}
        <div id="cwl-rounds-content">
            @foreach ($clan['cwl']['rounds'] as $index => $round)
                <div class="cwl-round-content {{ $loop->first ? '' : 'hidden' }}" id="round-{{ $index }}">
                    @foreach ($round['warTags'] ?? [] as $warTag)
                        @php $war = $clan['cwl']['wars'][$warTag] ?? null; @endphp
                        @if ($war)
                            @include('clan.partials.cwl-tab.cwl-war', ['war' => $war])
                        @elseif ($warTag !== '#0')
                            <div class="bg-gray-800/60 p-4 rounded text-gray-300 text-sm ring-1 ring-white/10 mb-4">
                                War data not available yet for {{ $warTag }}
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="bg-gray-800/50 rounded-lg p-6 mb-8">
    <h2 class="text-xl text-center font-bold mb-6">CWL Ranks & TH Counts</h2>

    {{-- Season Info --}}
    <div class="mb-4 text-center">
        <div class="text-blue-400 font-medium">
            Season: {{ $cwlGroup['season'] ?? 'Unknown' }}
        </div>
    </div>

    {{-- Matrix Table --}}
    <div class="overflow-x-auto rounded-lg ring-1 ring-white/10 bg-gray-900/30">
        <table class="min-w-[1000px] w-full text-sm text-gray-300">
            <thead class="bg-gray-800/70 sticky top-0 backdrop-blur supports-backdrop:backdrop-blur-sm">
                <tr>
                    <th class="px-4 py-3 text-left uppercase text-xs tracking-wider text-gray-300">Rank</th>
                    <th class="px-4 py-3 text-left uppercase text-xs tracking-wider text-gray-300">Clan</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">Stars</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">Destruction</th>
                    @for ($th = $maxTH; $th >= $minTH; $th--)
                        <th class="px-3 py-3 text-center">
                            <img 
                                src="{{ asset('images/TH/Town_Hall' . $th . '.webp') }}" 
                                alt="TH{{ $th }}" 
                                class="h-6 mx-auto" 
                                onerror="this.src='{{ asset('images/TH/Unknown.webp') }}'">
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @foreach($clanTHCounts as $index => $clanData)
                    @php
                        $warsPlayed = $clanData['warStats']['warCount'] ?? 0;
                        $avgDestCell = $warsPlayed > 0 ? ($clanData['warStats']['destruction'] / $warsPlayed) : 0;
                    @endphp
                    <tr class="hover:bg-gray-800/40 transition">
                        <td class="px-4 py-3 align-middle">
                            @if($index < 3)
                                @php $colors = ['from-yellow-400 to-amber-500','from-gray-300 to-gray-400','from-orange-300 to-amber-400']; @endphp
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $colors[$index] }} inline-flex items-center justify-center text-gray-900 font-extrabold">{{ $index + 1 }}</div>
                            @else
                                <span class="text-gray-400 font-semibold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap align-middle">
                            <div class="flex items-center gap-3">
                                <img src="{{ $clanData['badge'] }}" alt="{{ $clanData['name'] }}" class="w-8 h-8 rounded-full ring-1 ring-white/10" onerror="this.src='{{ asset('images/default_badge.png') }}'" loading="lazy" decoding="async">
                                <span class="font-semibold text-white">{{ $clanData['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center align-middle font-bold text-yellow-400">
                            {{ $clanData['warStats']['stars'] ?? 0 }}
                        </td>
                        <td class="px-4 py-3 text-center align-middle">
                            <div class="mx-auto w-24">
                                <div class="text-gray-200 font-medium">{{ number_format($avgDestCell, 1) }}%</div>
                                <div class="mt-1 h-1.5 w-full rounded bg-gray-700">
                                    <div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$avgDestCell)) }}%"></div>
                                </div>
                            </div>
                        </td>
                        @foreach($clanData['counts'] as $count)
                            <td class="px-3 py-3 text-center align-middle text-gray-200">
                                {{ $count }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Round tabs
        const roundButtons = document.querySelectorAll('.cwl-round-btn');
        const roundContents = document.querySelectorAll('.cwl-round-content');

        roundButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const roundIndex = btn.getAttribute('data-round');

                roundButtons.forEach(b => b.classList.replace('bg-blue-600', 'bg-gray-800/50'));
                btn.classList.replace('bg-gray-800/50', 'bg-blue-600');

                roundContents.forEach(c => c.classList.add('hidden'));
                document.getElementById(`round-${roundIndex}`).classList.remove('hidden');
            });
        });

        // Expand war content
        document.querySelectorAll('.toggle-war').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const content = document.getElementById(targetId);
                if (content) {
                    content.classList.toggle('hidden');
                    const caret = this.querySelector('.caret');
                    if (caret) {
                        caret.classList.toggle('rotate-180');
                    }
                }
            });
        });
    });
</script>

@include('clan.partials.cwl-tab.member-analytics', [
    'wars' => $clan['cwl']['wars'] ?? [],
    'pageClanTag' => $clan['tag'] ?? '',
    'pageClanName' => $clan['name'] ?? ''
])
