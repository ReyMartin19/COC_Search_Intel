@php
    $state = $war['state'] ?? 'unknown';
    $winnerLabel = null;
    $winnerClass = 'bg-gray-800/80 text-gray-300 ring-1 ring-white/10';

    if ($state === 'warEnded') {
        $clanStars = (int)($war['clan']['stars'] ?? 0);
        $opStars = (int)($war['opponent']['stars'] ?? 0);
        $clanDest = (float)($war['clan']['destructionPercentage'] ?? 0);
        $opDest = (float)($war['opponent']['destructionPercentage'] ?? 0);

        if ($clanStars === $opStars && abs($clanDest - $opDest) < 0.0001) {
            $winnerLabel = 'Tie';
            $winnerClass = 'bg-yellow-600/20 text-yellow-300 ring-1 ring-yellow-400/30';
        } elseif ($clanStars > $opStars || ($clanStars === $opStars && $clanDest > $opDest)) {
            $winnerLabel = $war['clan']['name'] ?? 'Clan';
            $winnerClass = 'bg-blue-600/20 text-blue-300 ring-1 ring-blue-400/30';
        } else {
            $winnerLabel = $war['opponent']['name'] ?? 'Opponent';
            $winnerClass = 'bg-red-600/20 text-red-300 ring-1 ring-red-400/30';
        }
    }
@endphp

<div class="relative z-10 flex justify-between items-center px-4 sm:px-6 py-3 cursor-pointer toggle-war group" data-target="{{ $warId }}">
    <div class="flex items-center gap-3">
        <img src="{{ $war['clan']['badgeUrls']['small'] ?? asset('images/default_badge.png') }}" class="w-8 h-8 rounded-full ring-1 ring-purple-500/30" alt="Clan Badge" loading="lazy" decoding="async">
        <span class="text-purple-300 font-semibold">{{ $war['clan']['name'] ?? 'Clan' }}</span>
        <span class="text-yellow-400 font-bold mx-2">vs</span>
        <span class="text-red-300 font-semibold">{{ $war['opponent']['name'] ?? 'Opponent' }}</span>
    </div>
    <div class="flex items-center gap-3">
        <span class="text-xs px-2 py-1 rounded-full {{ $winnerLabel ? $winnerClass : 'bg-gray-800/80 text-gray-300 ring-1 ring-white/10' }}">
            {{ $winnerLabel ? $winnerLabel : ucfirst($state) }}
        </span>
        <svg class="caret w-4 h-4 text-gray-400 transition-transform duration-200 group-hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</div>