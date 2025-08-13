@isset($player)
@php
    $troopData = get_troop_data($player);

    // Map super troops to their base troop names
    $superTroopMap = [
        'Super Barbarian' => 'Barbarian',
        'Super Archer' => 'Archer',
        'Super Giant' => 'Giant',
        'Sneaky Goblin' => 'Goblin',
        'Super Wall Breaker' => 'Wall Breaker',
        'Rocket Balloon' => 'Balloon',
        'Super Wizard' => 'Wizard',
        'Super Dragon' => 'Dragon',
        'Inferno Dragon' => 'Baby Dragon',
        'Super Miner' => 'Miner',
        'Super Valkyrie' => 'Valkyrie',
        'Super Witch' => 'Witch',
        'Ice Hound' => 'Lava Hound',
        'Super Bowler' => 'Bowler',
        'Super Hog Rider' => 'Hog Rider',
        'Apprentice Warden' => 'Healer',
        'Super Yeti' => 'Yeti',
        'Super Minion' => 'Minion',
    ];
@endphp

<div class="w-full text-white font-sans">
    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-6 shadow-lg shadow-black/30">
        <div class="absolute -top-12 -left-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>

        <div class="space-y-10">
            @foreach($troopData['groupedTroops'] as $category => $troopList)
                <div>
                    {{-- Category Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg sm:text-xl font-bold text-white relative pl-3">
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 rounded-full bg-gradient-to-b from-purple-400 to-blue-400"></span>
                            {{ $category }}
                        </h2>
                        @php $owned = 0; $total = count($troopList); @endphp
                        @foreach($troopList as $troopName)
                            @php
                                $isPet = $category === 'Hero Pets';
                                $collection = $isPet ? $troopData['playerPets'] : $troopData['playerTroops'];
                                $data = $collection->first(fn ($item) => strtolower(trim($item['name'])) === strtolower(trim($troopName)));
                                if ($data) { $owned++; }
                            @endphp
                        @endforeach
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-800/80 text-gray-300 ring-1 ring-white/10">
                            {{ $owned }} / {{ $total }}
                        </span>
                    </div>

                    {{-- Troop Grid --}}
                    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-4 sm:p-5 shadow-lg shadow-black/30">
                        <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-9 gap-5 w-full">
                            @foreach($troopList as $troopName)
                                @php
                                    $isPet = $category === 'Hero Pets';
                                    $collection = $isPet ? $troopData['playerPets'] : $troopData['playerTroops'];

                                    $data = $collection->first(fn ($item) => strtolower(trim($item['name'])) === strtolower(trim($troopName)));

                                    // If troop is a super troop, override with base troop data
                                    if (isset($superTroopMap[$troopName])) {
                                        $baseName = $superTroopMap[$troopName];
                                        $baseData = $troopData['playerTroops']->first(fn ($item) => strtolower(trim($item['name'])) === strtolower(trim($baseName)));
                                        if ($baseData) {
                                            $data = $baseData;
                                        }
                                    }

                                    $hasTroop = $data !== null;
                                    $level = (int)($data['level'] ?? 0);
                                    $maxLevel = $data['maxLevel'] ?? null;
                                    $troopImage = format_troop_image_name($troopName);
                                    $folder = $troopData['categoryFolders'][$category] ?? 'TH/Other';
                                    $imagePath = asset("images/{$folder}/{$troopImage}");
                                    $isMaxed = $maxLevel && $level >= $maxLevel;
                                    $pct = $maxLevel ? max(0, min(100, ($level / max(1, $maxLevel)) * 100)) : 0;
                                @endphp
                                
                                <div class="relative group flex flex-col items-center">
                                    {{-- Troop Image --}}
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-900 ring-1 ring-white/10 p-1 shadow-lg shadow-black/30 flex items-center justify-center transition duration-300 group-hover:scale-105 group-hover:ring-purple-400/40">
                                        <img src="{{ $imagePath }}" 
                                             alt="{{ $troopName }}" 
                                             class="w-full h-full rounded-full object-contain transition-all duration-300 @if(!$hasTroop) grayscale opacity-40 @else group-hover:scale-110 @endif"
                                             loading="lazy" decoding="async">
                                    </div>

                                    {{-- Level Badge --}}
                                    <div class="absolute -top-1 -right-1 flex items-center justify-center rounded-full w-7 h-7 text-[10px] font-extrabold shadow-md
                                                @if($hasTroop && $isMaxed) bg-gradient-to-br from-emerald-500 to-green-600 text-white ring-1 ring-emerald-300/40 
                                                @elseif($hasTroop) bg-gradient-to-br from-blue-500 to-blue-700 text-white ring-1 ring-blue-300/40 
                                                @else bg-gray-700 text-gray-300 ring-1 ring-white/10 @endif">
                                        {{ $hasTroop ? $level : 'Lv 0' }}
                                    </div>

                                    {{-- Progress Bar --}}
                                    @if($hasTroop && $maxLevel)
                                        <div class="mt-2 w-full">
                                            <div class="h-1.5 w-full rounded bg-gray-800 overflow-hidden">
                                                <div class="h-1.5 rounded transition-all duration-700 ease-out
                                                            @if($isMaxed) bg-gradient-to-r from-green-400 to-emerald-500 
                                                            @else bg-gradient-to-r from-blue-400 to-purple-400 @endif"
                                                     style="width: {{ $pct }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Troop Name --}}
                                    <div class="mt-1 text-[11px] text-gray-300 text-center truncate max-w-[5rem]">
                                        {{ $troopName }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endisset
