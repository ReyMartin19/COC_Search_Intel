<div class="space-y-4">
    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-yellow-400 mr-3">home_work</span>
            <span>Builder Hall</span>
        </div>
        <span class="font-bold">{{ $player['builderHallLevel'] ?? '0' }}</span>
    </div>

    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-purple-400 mr-3">emoji_events</span>
            <span>Trophies</span>
        </div>
        <span class="font-bold">{{ $player['builderBaseTrophies'] ?? '0' }}</span>
    </div>

    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-blue-400 mr-3">stars</span>
            <span>Best Trophies</span>
        </div>
        <span class="font-bold">{{ $player['bestBuilderBaseTrophies'] ?? '0' }}</span>
    </div>

    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-yellow-500 mr-3">castle</span>
            <span>Capital Contributions</span>
        </div>
        <span class="font-bold">{{ $player['clanCapitalContributions'] ?? '0' }}</span>
    </div>
</div>
