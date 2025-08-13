<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-lg p-5 border border-purple-500/30 shadow-md backdrop-blur-sm lg:col-span-2">
    <h3 class="text-gray-300 text-base font-semibold mb-5 uppercase tracking-wide flex items-center gap-2">
        <span class="material-symbols-outlined text-yellow-400 text-lg">emoji_events</span>
        Score
    </h3>

    <div class="flex justify-between items-center">
        
        <!-- Clan Side -->
        <div class="text-center p-3 rounded-lg hover:bg-purple-500/10 transition-all duration-300">
            <img src="{{ $war['clan']['badgeUrls']['small'] ?? asset('images/default_badge.png') }}" 
                 alt="Clan Badge" class="w-14 h-14 mx-auto mb-2 drop-shadow-lg" loading="lazy" decoding="async">
            <p class="text-white font-bold text-lg">{{ $war['clan']['name'] ?? 'Unknown' }}</p>
            <p class="text-yellow-400 text-3xl font-extrabold mt-1">
                {{ $war['clan']['stars'] ?? 0 }} ★
            </p>
            <p class="text-white font-medium mt-1">
                {{ number_format($war['clan']['destructionPercentage'] ?? 0, 1) }}%
            </p>
        </div>

        <!-- Divider -->
        <div class="h-20 w-px bg-purple-500/30"></div>

        <!-- Opponent Side -->
        <div class="text-center p-3 rounded-lg hover:bg-purple-500/10 transition-all duration-300">
            <img src="{{ $war['opponent']['badgeUrls']['small'] ?? asset('images/default_badge.png') }}" 
                 alt="Opponent Badge" class="w-14 h-14 mx-auto mb-2 drop-shadow-lg" loading="lazy" decoding="async">
            <p class="text-white font-bold text-lg">{{ $war['opponent']['name'] ?? 'Unknown' }}</p>
            <p class="text-yellow-400 text-3xl font-extrabold mt-1">
                {{ $war['opponent']['stars'] ?? 0 }} ★
            </p>
            <p class="text-white font-medium mt-1">
                {{ number_format($war['opponent']['destructionPercentage'] ?? 0, 1) }}%
            </p>
        </div>

    </div>
</div>
