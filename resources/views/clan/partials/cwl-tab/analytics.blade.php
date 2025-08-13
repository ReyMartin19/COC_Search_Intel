@php
    // Prepare per-clan season stats from wars
    $perClan = [];
    foreach (($wars ?? []) as $warTag => $war) {
        if (!is_array($war) || empty($war)) continue;

        foreach (['clan', 'opponent'] as $side) {
            $entry = $war[$side] ?? null;
            if (!$entry || !isset($entry['tag'])) continue;

            $tag = $entry['tag'];
            $name = $entry['name'] ?? $tag;

            if (!isset($perClan[$tag])) {
                $perClan[$tag] = [
                    'tag' => $tag,
                    'name' => $name,
                    'badge' => $entry['badgeUrls']['small'] ?? asset('images/default_badge.png'),
                    'wars' => 0,
                    'stars' => 0,
                    'attacks' => 0,
                    'destruction' => 0.0,
                    'bestStars' => 0,
                    'bestDest' => 0.0,
                    'worstStars' => PHP_INT_MAX,
                    'worstDest' => 101.0
                ];
            }

            $perClan[$tag]['wars'] += 1;
            $perClan[$tag]['stars'] += (int)($entry['stars'] ?? 0);
            $perClan[$tag]['attacks'] += (int)($entry['attacks'] ?? 0);
            $perClan[$tag]['destruction'] += (float)($entry['destructionPercentage'] ?? 0);
            $perClan[$tag]['bestStars'] = max($perClan[$tag]['bestStars'], (int)($entry['stars'] ?? 0));
            $perClan[$tag]['bestDest'] = max($perClan[$tag]['bestDest'], (float)($entry['destructionPercentage'] ?? 0));
            $perClan[$tag]['worstStars'] = min($perClan[$tag]['worstStars'], (int)($entry['stars'] ?? 0));
            $perClan[$tag]['worstDest'] = min($perClan[$tag]['worstDest'], (float)($entry['destructionPercentage'] ?? 0));
        }
    }

    // Normalize worst values if no data
    foreach ($perClan as $k => $v) {
        if ($perClan[$k]['worstStars'] === PHP_INT_MAX) $perClan[$k]['worstStars'] = 0;
        if ($perClan[$k]['worstDest'] === 101.0) $perClan[$k]['worstDest'] = 0.0;
    }

    // Extract current clan
    $ourTag = $pageClanTag ?? '';
    $our = $perClan[$ourTag] ?? null;

    // Top performers by stars and avg destruction
    $topStars = $perClan;
    uasort($topStars, fn($a,$b) => ($b['stars'] <=> $a['stars']));
    $topStars = array_slice($topStars, 0, 5);

    $topAvgDest = $perClan;
    foreach ($topAvgDest as $k => $v) {
        $topAvgDest[$k]['avgDest'] = ($v['wars'] ?? 0) > 0 ? $v['destruction'] / $v['wars'] : 0; 
    }
    uasort($topAvgDest, fn($a,$b) => (($b['avgDest'] ?? 0) <=> ($a['avgDest'] ?? 0)));
    $topAvgDest = array_slice($topAvgDest, 0, 5);
@endphp

<div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-6 shadow-lg shadow-black/30 mt-8">
    <div class="absolute -bottom-12 -right-12 h-40 w-40 rounded-full bg-purple-500/10 blur-3xl"></div>

    <h3 class="text-xl font-bold text-white mb-5 text-center">CWL Analytics</h3>

    @if($our)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="rounded-lg p-4 bg-gray-800/60 ring-1 ring-white/5">
            <h4 class="text-sm font-semibold text-gray-200 mb-3">Our Clan Snapshot</h4>
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ $our['badge'] }}" class="w-8 h-8 rounded-full" alt="badge" onerror="this.src='{{ asset('images/default_badge.png') }}'" loading="lazy" decoding="async">
                <div class="text-white font-semibold">{{ $pageClanName ?? $our['name'] }}</div>
                <div class="ml-auto text-xs px-2 py-1 rounded-full bg-gray-900/60 text-gray-300 ring-1 ring-white/10">Wars: {{ $our['wars'] }}</div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <span>Stars</span>
                    <span class="ml-auto font-extrabold text-yellow-400">{{ $our['stars'] }}</span>
                </div>
                @php $ourAvg = ($our['wars'] ?? 0) > 0 ? $our['destruction'] / $our['wars'] : 0; @endphp
                <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 text-gray-300">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-400" viewBox="0 0 24 24" fill="currentColor"><path d="M13 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                        <span>Avg Destruction</span>
                        <span class="ml-auto font-semibold text-orange-400">{{ number_format($ourAvg, 1) }}%</span>
                    </div>
                    <div class="mt-2 h-1.5 w-full rounded bg-gray-700"><div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$ourAvg)) }}%"></div></div>
                </div>
                <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 14L21 3m0 0h-7m7 0v7"/><path d="M14 10l-1-1"/></svg>
                    <span>Attacks</span>
                    <span class="ml-auto font-semibold text-gray-200">{{ $our['attacks'] }}</span>
                </div>
                <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-emerald-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422A12 12 0 0112 22 12 12 0 015.84 10.578L12 14z"/></svg>
                    <span>Best Stars</span>
                    <span class="ml-auto font-semibold text-gray-200">{{ $our['bestStars'] }}</span>
                </div>
            </div>
        </div>

        <div class="rounded-lg p-4 bg-gray-800/60 ring-1 ring-white/5">
            <h4 class="text-sm font-semibold text-gray-200 mb-3">Top 5 Clans by Stars</h4>
            <div class="space-y-2">
                                 @foreach($topStars as $row)
                 <div class="flex items-center gap-3 bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5">
                     <img src="{{ $row['badge'] }}" class="w-6 h-6 rounded" alt="badge" onerror="this.src='{{ asset('images/default_badge.png') }}'" loading="lazy" decoding="async">
                     <span class="text-white font-medium">{{ $row['name'] }}</span>
                     <span class="ml-auto text-yellow-400 font-bold">{{ $row['stars'] }}</span>
                 </div>
                 @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="rounded-lg p-4 bg-gray-800/60 ring-1 ring-white/5">
        <h4 class="text-sm font-semibold text-gray-200 mb-3">Top 5 Clans by Avg Destruction</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($topAvgDest as $row)
            @php $avg = ($row['wars'] ?? 0) > 0 ? $row['destruction'] / $row['wars'] : 0; @endphp
            <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-3 text-gray-300">
                    <img src="{{ $row['badge'] }}" class="w-6 h-6 rounded" alt="badge" onerror="this.src='{{ asset('images/default_badge.png') }}'" loading="lazy" decoding="async">
                    <span class="text-white font-medium">{{ $row['name'] }}</span>
                    <span class="ml-auto text-orange-400 font-semibold">{{ number_format($avg, 1) }}%</span>
                </div>
                <div class="mt-2 h-1.5 w-full rounded bg-gray-700"><div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$avg)) }}%"></div></div>
            </div>
            @endforeach
        </div>
    </div>
</div>


