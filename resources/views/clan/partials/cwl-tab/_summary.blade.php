@php
    use Carbon\Carbon;
    try {
        $start = Carbon::createFromFormat('Ymd\THis.v\Z', $war['startTime'] ?? '')->setTimezone('UTC');
    } catch (\Exception $e) {
        $start = null;
    }
@endphp

<div class="rounded-lg p-4 sm:p-5 mb-6 bg-gray-800/60 ring-1 ring-white/5">
    <h3 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-purple-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 3v18M5 3h11l-1 3 1 3H5"/></svg>
        War Summary
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm text-gray-300">

        {{-- Left Column --}}
        <div class="space-y-3">
            <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <span>Stars</span>
                <span class="ml-auto">
                    <span class="text-blue-400 font-semibold">{{ $war['clan']['stars'] ?? 0 }}</span> 
                    <span class="text-gray-400">vs</span>
                    <span class="text-red-400 font-semibold">{{ $war['opponent']['stars'] ?? 0 }}</span>
                </span>
            </div>

            <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 text-gray-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                    <span>Destruction</span>
                    <span class="ml-auto">
                        <span class="text-blue-400 font-semibold">{{ number_format($war['clan']['destructionPercentage'] ?? 0, 1) }}%</span>
                        <span class="text-gray-400">vs</span>
                        <span class="text-red-400 font-semibold">{{ number_format($war['opponent']['destructionPercentage'] ?? 0, 1) }}%</span>
                    </span>
                </div>
                <div class="mt-2 h-1.5 w-full rounded bg-gray-700">
                    @php $our = (float)($war['clan']['destructionPercentage'] ?? 0); @endphp
                    <div class="h-1.5 rounded bg-gradient-to-r from-orange-400 to-yellow-400" style="width: {{ max(0,min(100,$our)) }}%"></div>
                </div>
            </div>

            <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 14L21 3m0 0h-7m7 0v7"/><path d="M14 10l-1-1"/></svg>
                <span>Attacks</span>
                <span class="ml-auto">
                    <span class="text-blue-400 font-semibold">{{ $war['clan']['attacks'] ?? 0 }}</span>
                    <span class="text-gray-400">vs</span>
                    <span class="text-red-400 font-semibold">{{ $war['opponent']['attacks'] ?? 0 }}</span>
                </span>
            </div>

            <div class="text-xs text-gray-400 italic ml-1">
                War started: {{ $start ? $start->diffForHumans() : 'N/A' }}
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-3">
            <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 8l3-3 3 3M6 20l6-6 6 6"/></svg>
                <span>Clan Level</span>
                <span class="ml-auto">
                    <span class="text-blue-400 font-semibold">{{ $war['clan']['clanLevel'] ?? 0 }}</span>
                    <span class="text-gray-400">vs</span>
                    <span class="text-red-400 font-semibold">{{ $war['opponent']['clanLevel'] ?? 0 }}</span>
                </span>
            </div>

            <div class="bg-gray-900/40 rounded-md px-3 py-2 ring-1 ring-white/5 flex items-center gap-2">
                <svg class="w-4 h-4 text-teal-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 7h18M6 12h12M9 17h6"/></svg>
                <span>Team Size</span>
                <span class="ml-auto text-white font-semibold">{{ $war['teamSize'] ?? 0 }}</span>
            </div>
        </div>

    </div>
</div>
