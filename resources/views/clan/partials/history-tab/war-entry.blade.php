@php
    use Carbon\Carbon;

    $pageClanTag = $pageClanTag ?? null;
    $isOurClan = $pageClanTag ? (($log['clan']['tag'] ?? '') === $pageClanTag) : true;
    $clan = $isOurClan ? $log['clan'] : $log['opponent'];

    $endTime = isset($log['endTime']) ? Carbon::createFromFormat('Ymd\THis.v\Z', $log['endTime'])->format('M j, Y') : 'N/A';

    // Custom Result Logic - Different for CWL and regular wars
    if ($isCWL) {
        // For CWL, use the result field directly
        $result = $log['result'] ?? null;
        
        if ($result === 'win') {
            $resultLabel = 'Promoted';
            $resultColor = 'text-green-400 bg-green-900';
        } elseif ($result === 'lose') {
            $resultLabel = 'Demoted';
            $resultColor = 'text-red-400 bg-red-900';
        } elseif ($result === 'tie') {
            $resultLabel = 'Demoted'; // Ties typically result in demotion
            $resultColor = 'text-yellow-300 bg-yellow-900';
        } elseif ($isCurrent ?? false) {
            $resultLabel = 'Ongoing';
            $resultColor = 'text-blue-400 bg-blue-900';
        } else {
            $resultLabel = 'Stayed';
            $resultColor = 'text-gray-400 bg-gray-800';
        }
    } else {
        // Regular war result logic (keep your existing code)
        $stars = $clan['stars'] ?? 0;
        $opStars = $isOurClan ? ($log['opponent']['stars'] ?? 0) : ($log['clan']['stars'] ?? 0);
        $destruction = $clan['destructionPercentage'] ?? 0;
        $opDestruction = $isOurClan ? ($log['opponent']['destructionPercentage'] ?? 0) : ($log['clan']['destructionPercentage'] ?? 0);

        if ($stars > $opStars || ($stars === $opStars && $destruction > $opDestruction)) {
            $resultLabel = 'Victory';
            $resultColor = 'text-green-400 bg-green-900';
        } elseif ($stars < $opStars || ($stars === $opStars && $destruction < $opDestruction)) {
            $resultLabel = 'Defeat';
            $resultColor = 'text-red-400 bg-red-900';
        } else {
            $resultLabel = 'Draw';
            $resultColor = 'text-yellow-300 bg-yellow-900';
        }
    }
@endphp

@if($isCWL && (!isset($log['round']) || $log['round'] === null))
    {{-- Display CWL summary entry --}}
    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-5 shadow-lg shadow-black/30 hover:border-purple-500/40 transition">
        <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ $clan['badgeUrls']['small'] ?? asset('images/default_badge.png') }}" alt="badge" class="w-10 h-10 rounded-full ring-1 ring-purple-500/30">
                <div>
                    <div class="text-base font-extrabold tracking-wide text-purple-300">{{ $clan['name'] ?? 'Unknown' }}</div>
                    <div class="text-[11px] uppercase tracking-wider text-gray-400">{{ $clan['tag'] ?? '#' }}</div>
                </div>
            </div>
            <div class="px-3 py-1.5 text-xs rounded-full font-semibold {{ $resultColor }} ring-1 ring-white/10 shadow">
                {{ $resultLabel }}
            </div>
        </div>

        @php
            $avgDestructionValue = (float)($clan['destructionPercentage'] ?? 0);
        @endphp

        @if(isset($isAggregated) && $isAggregated)
        {{-- Aggregated CWL stats display --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 text-sm">
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-purple-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m2-9l2 9m8-9l2 9m-2-9H7"/></svg>
                    <span class="text-gray-400">Wars</span>
                    <span class="ml-auto font-semibold text-gray-200">{{ $log['warCount'] ?? 0 }}</span>
                </div>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-purple-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 12h18M12 3v18"/></svg>
                    <span class="text-gray-400">Size</span>
                    <span class="ml-auto font-semibold text-gray-200">{{ $log['teamSize'] ?? '?' }}v{{ $log['teamSize'] ?? '?' }}</span>
                </div>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <span class="text-gray-400">Total Stars</span>
                    <span class="ml-auto font-extrabold text-yellow-400">{{ $clan['stars'] ?? 0 }}</span>
                </div>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-orange-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                    <span class="text-gray-400">Avg Destruction</span>
                    <span class="ml-auto font-semibold text-orange-400">{{ number_format($clan['destructionPercentage'] ?? 0, 1) }}%</span>
                </div>
                <div class="mt-2 h-1.5 w-full rounded bg-gray-700">
                    <div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$avgDestructionValue)) }}%"></div>
                </div>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 14L21 3m0 0h-7m7 0v7"/><path d="M14 10l-1-1"/></svg>
                    <span class="text-gray-400">Total Attacks</span>
                    <span class="ml-auto font-semibold text-gray-200">{{ $clan['attacks'] ?? 0 }}</span>
                </div>
            </div>
            @if($endTime !== 'N/A')
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9"/></svg>
                    <span class="text-gray-400">Latest End</span>
                    <span class="ml-auto font-medium text-gray-200">{{ $endTime }}</span>
                </div>
            </div>
            @endif
        </div>
        @else
        {{-- Single CWL war stats display --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9"/></svg>
                <span class="text-gray-400">End</span>
                <span class="ml-auto font-medium text-gray-200">{{ $endTime }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-purple-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 12h18M12 3v18"/></svg>
                <span class="text-gray-400">Size</span>
                <span class="ml-auto font-semibold text-gray-200">{{ $log['teamSize'] ?? '?' }}v{{ $log['teamSize'] ?? '?' }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <span class="text-gray-400">Stars</span>
                <span class="ml-auto font-extrabold text-yellow-400">{{ $clan['stars'] ?? 0 }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 text-gray-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                    <span class="text-gray-400">Destruction</span>
                    <span class="ml-auto font-semibold text-orange-400">{{ number_format($clan['destructionPercentage'] ?? 0, 1) }}%</span>
                </div>
                <div class="mt-2 h-1.5 w-full rounded bg-gray-700">
                    <div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$avgDestructionValue)) }}%"></div>
                </div>
            </div>
        </div>
        @endif
    </div>
@elseif(!$isCWL)
    {{-- Regular war entry --}}
    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-5 shadow-lg shadow-black/30 hover:border-purple-500/40 transition">
        <div class="absolute -top-10 -left-10 h-28 w-28 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ $clan['badgeUrls']['small'] ?? asset('images/default_badge.png') }}" alt="badge" class="w-10 h-10 rounded-full ring-1 ring-purple-500/30">
                <div>
                    <div class="text-base font-extrabold tracking-wide text-purple-300">{{ $clan['name'] ?? 'Unknown' }}</div>
                    <div class="text-[11px] uppercase tracking-wider text-gray-400">{{ $clan['tag'] ?? '#' }}</div>
                </div>
            </div>
            <div class="px-3 py-1.5 text-xs rounded-full font-semibold {{ $resultColor }} ring-1 ring-white/10 shadow">
                {{ $resultLabel }}
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9"/></svg>
                <span class="text-gray-400">End</span>
                <span class="ml-auto font-medium text-gray-200">{{ $endTime }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-purple-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 12h18M12 3v18"/></svg>
                <span class="text-gray-400">Size</span>
                <span class="ml-auto font-semibold text-gray-200">{{ $log['teamSize'] ?? '?' }}v{{ $log['teamSize'] ?? '?' }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 14L21 3m0 0h-7m7 0v7"/><path d="M14 10l-1-1"/></svg>
                <span class="text-gray-400">Attacks/Member</span>
                <span class="ml-auto font-semibold text-gray-200">{{ $log['attacksPerMember'] ?? '?' }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <span class="text-gray-400">Stars</span>
                <span class="ml-auto font-extrabold text-yellow-400">{{ $clan['stars'] ?? 0 }}</span>
            </div>
            @php $regAvgDestruction = (float)($clan['destructionPercentage'] ?? 0); @endphp
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 text-gray-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                    <span class="text-gray-400">Destruction</span>
                    <span class="ml-auto font-semibold text-orange-400">{{ number_format($clan['destructionPercentage'] ?? 0, 1) }}%</span>
                </div>
                <div class="mt-2 h-1.5 w-full rounded bg-gray-700">
                    <div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$regAvgDestruction)) }}%"></div>
                </div>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 14L21 3m0 0h-7m7 0v7"/><path d="M14 10l-1-1"/></svg>
                <span class="text-gray-400">Attacks</span>
                <span class="ml-auto font-semibold text-gray-200">{{ $clan['attacks'] ?? 0 }}</span>
            </div>
            <div class="bg-gray-800/60 rounded-lg px-3 py-2 ring-1 ring-white/5 flex items-center gap-2 text-gray-300">
                <svg class="w-4 h-4 text-emerald-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422A12 12 0 0112 22 12 12 0 015.84 10.578L12 14z"/></svg>
                <span class="text-gray-400">Level</span>
                <span class="ml-auto font-semibold text-gray-200">{{ $clan['clanLevel'] ?? 0 }}</span>
            </div>
        </div>
    </div>
@endif