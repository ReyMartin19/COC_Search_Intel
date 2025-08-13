@php
    // Aggregate member-level stats for our clan across all CWL wars
    $ourTag = $pageClanTag ?? '';
    $memberStats = []; // key: playerTag

    foreach (($wars ?? []) as $warTag => $war) {
        if (!is_array($war) || empty($war)) continue;

        // Choose our side for this war
        $sideKey = null;
        if (($war['clan']['tag'] ?? '') === $ourTag) $sideKey = 'clan';
        elseif (($war['opponent']['tag'] ?? '') === $ourTag) $sideKey = 'opponent';
        else continue;

        foreach (($war[$sideKey]['members'] ?? []) as $member) {
            $tag = $member['tag'] ?? null;
            if (!$tag) continue;

            if (!isset($memberStats[$tag])) {
                $memberStats[$tag] = [
                    'tag' => $tag,
                    'name' => $member['name'] ?? $tag,
                    'th' => $member['townhallLevel'] ?? ($member['townHallLevel'] ?? null),
                    'attacks' => 0,
                    'stars' => 0,
                    'destruction' => 0.0,
                    'bestAttackStars' => 0,
                    'bestAttackDest' => 0.0,
                    'avgDest' => 0.0,
                ];
            }

            $attacks = $member['attacks'] ?? [];
            foreach ($attacks as $atk) {
                $memberStats[$tag]['attacks'] += 1;
                $memberStats[$tag]['stars'] += (int)($atk['stars'] ?? 0);
                $d = (float)($atk['destructionPercentage'] ?? 0);
                $memberStats[$tag]['destruction'] += $d;
                $memberStats[$tag]['bestAttackStars'] = max($memberStats[$tag]['bestAttackStars'], (int)($atk['stars'] ?? 0));
                $memberStats[$tag]['bestAttackDest'] = max($memberStats[$tag]['bestAttackDest'], $d);
            }
        }
    }

    // Compute averages
    foreach ($memberStats as $k => $m) {
        $att = $m['attacks'] ?: 0;
        $memberStats[$k]['avgDest'] = $att > 0 ? $m['destruction'] / $att : 0;
    }

    // Build leaderboards
    $topStars = $memberStats;
    uasort($topStars, fn($a,$b) => ($b['stars'] <=> $a['stars']) ?: (($b['avgDest'] ?? 0) <=> ($a['avgDest'] ?? 0)));
    $topStars = array_slice($topStars, 0, 10);

    $topAvgDest = $memberStats;
    uasort($topAvgDest, fn($a,$b) => (($b['avgDest'] ?? 0) <=> ($a['avgDest'] ?? 0)) ?: ($b['stars'] <=> $a['stars']));
    $topAvgDest = array_slice($topAvgDest, 0, 10);

    $mostAttacks = $memberStats;
    uasort($mostAttacks, fn($a,$b) => ($b['attacks'] <=> $a['attacks']) ?: ($b['stars'] <=> $a['stars']));
    $mostAttacks = array_slice($mostAttacks, 0, 10);
@endphp

<div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-6 shadow-lg shadow-black/30 mt-8">
    <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>

    <h3 class="text-xl font-bold text-white mb-5 text-center">CWL Member Analytics — {{ $pageClanName }}</h3>

    @if(empty($memberStats))
        <div class="text-center text-gray-400">No member attack data available.</div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="rounded-lg p-4 bg-gray-800/60 ring-1 ring-white/5">
            <h4 class="text-sm font-semibold text-gray-200 mb-3">Top Stars</h4>
            <div class="space-y-2">
                @foreach($topStars as $m)
                <div class="flex items-center gap-3 bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5">
                    <div class="text-xs px-2 py-1 rounded bg-gray-800/70 text-gray-300">TH{{ $m['th'] ?? '?' }}</div>
                    <span class="text-white font-medium truncate">{{ $m['name'] }}</span>
                    <span class="ml-auto text-yellow-400 font-bold">{{ $m['stars'] }}★</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg p-4 bg-gray-800/60 ring-1 ring-white/5">
            <h4 class="text-sm font-semibold text-gray-200 mb-3">Best Avg Destruction</h4>
            <div class="space-y-2">
                @foreach($topAvgDest as $m)
                @php $avg = number_format($m['avgDest'] ?? 0, 1); @endphp
                <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5">
                    <div class="flex items-center gap-2 text-gray-300">
                        <div class="text-xs px-2 py-1 rounded bg-gray-800/70 text-gray-300">TH{{ $m['th'] ?? '?' }}</div>
                        <span class="text-white font-medium truncate">{{ $m['name'] }}</span>
                        <span class="ml-auto text-orange-400 font-semibold">{{ $avg }}%</span>
                    </div>
                    <div class="mt-2 h-1.5 w-full rounded bg-gray-700">
                        <div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$m['avgDest'] ?? 0)) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg p-4 bg-gray-800/60 ring-1 ring-white/5">
            <h4 class="text-sm font-semibold text-gray-200 mb-3">Most Attacks</h4>
            <div class="space-y-2">
                @foreach($mostAttacks as $m)
                <div class="flex items-center gap-3 bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5">
                    <div class="text-xs px-2 py-1 rounded bg-gray-800/70 text-gray-300">TH{{ $m['th'] ?? '?' }}</div>
                    <span class="text-white font-medium truncate">{{ $m['name'] }}</span>
                    <span class="ml-auto text-blue-300 font-semibold">{{ $m['attacks'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>


