<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-lg p-5 border border-purple-500/30 shadow-md backdrop-blur-sm">
    <h3 class="text-gray-300 text-base font-semibold mb-4 uppercase tracking-wide flex items-center gap-2">
        <span class="material-symbols-outlined text-purple-400 text-lg">info</span>
        War Details
    </h3>

    <div class="space-y-3">
        <!-- War Type -->
        <div class="flex justify-between items-center">
            <span class="flex items-center gap-2 text-gray-400">
                <span class="material-symbols-outlined text-yellow-400 text-sm">military_tech</span>
                War Type:
            </span>
            <span class="text-white font-medium">
                {{ ucfirst($war['type'] ?? 'Clan War') }}
            </span>
        </div>

        <!-- War Size -->
        <div class="flex justify-between items-center">
            <span class="flex items-center gap-2 text-gray-400">
                <span class="material-symbols-outlined text-blue-400 text-sm">group</span>
                War Size:
            </span>
            <span class="text-white font-medium">
                {{ $war['teamSize'] ?? 0 }} vs {{ $war['teamSize'] ?? 0 }}
            </span>
        </div>

        <!-- Attack Mode -->
        <div class="flex justify-between items-center">
            <span class="flex items-center gap-2 text-gray-400">
                <span class="material-symbols-outlined text-green-400 text-sm">swords</span>
                Attack Mode:
            </span>
            <span class="text-white font-medium flex items-center">
                Attacks
                <span class="inline-flex items-center justify-center bg-blue-500/20 text-blue-300 rounded-full h-5 w-5 mx-1 text-xs">
                    ×
                </span>
                {{ $war['attacksPerMember'] ?? 0 }}
            </span>
        </div>
    </div>
</div>
