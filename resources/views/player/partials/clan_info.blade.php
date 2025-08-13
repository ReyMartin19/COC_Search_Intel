<div class="flex items-center mb-4">
    <img 
        src="{{ asset('images/clans/' . strtolower($player['clan']['name']) . '.webp') }}" 
        class="w-16 h-16 mr-4" 
        alt="{{ $player['clan']['name'] }}"
        onerror="this.style.display='none';"
    />
    <div>
        <h3 class="text-lg font-bold">{{ $player['clan']['name'] }}</h3>
        <p class="text-gray-400">{{ $player['clan']['tag'] }} • Level {{ $player['clan']['clanLevel'] }}</p>
        <span class="inline-block mt-2 bg-purple-600 text-white text-xs px-3 py-1 rounded-full">
            {{ ucfirst($player['role']) }}
        </span>
    </div>
</div>

<div class="grid grid-cols-3 gap-3 mt-5">
    <div class="bg-gray-900 p-3 rounded-lg text-center hover:bg-gray-900/80 transition">
        <span class="material-symbols-outlined text-yellow-500 mb-1">military_tech</span>
        <div class="text-xs text-gray-400">War Stars</div>
        <div class="font-bold">{{ $player['warStars'] ?? '0' }}</div>
    </div>

    <div class="bg-gray-900 p-3 rounded-lg text-center hover:bg-gray-900/80 transition">
        <span class="material-symbols-outlined text-green-500 mb-1">arrow_upward</span>
        <div class="text-xs text-gray-400">Donations</div>
        <div class="font-bold">{{ $player['donations'] ?? '0' }}</div>
    </div>

    <div class="bg-gray-900 p-3 rounded-lg text-center hover:bg-gray-900/80 transition">
        <span class="material-symbols-outlined text-yellow-500 mb-1">arrow_downward</span>
        <div class="text-xs text-gray-400">Received</div>
        <div class="font-bold">{{ $player['donationsReceived'] ?? '0' }}</div>
    </div>
</div>


