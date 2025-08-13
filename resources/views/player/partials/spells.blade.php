@isset($player)
@php
// Define spell categories
$elixirSpells = [
    'Lightning Spell', 'Healing Spell', 'Rage Spell', 'Jump Spell',
    'Freeze Spell', 'Clone Spell', 'Invisibility Spell',
    'Recall Spell', 'Revive Spell'
];

$darkSpells = [
    'Poison Spell', 'Earthquake Spell', 'Haste Spell',
    'Skeleton Spell', 'Bat Spell', 'Overgrowth Spell', 'Ice Block Spell'
];

// Grouped spell lists to display all by name
$groupedSpells = [
    'Elixir Spells' => $elixirSpells,
    'Dark Elixir Spells' => $darkSpells,
];

// Folder mapping
$categoryFolders = [
    'Elixir Spells' => 'TH/E_Spells',
    'Dark Elixir Spells' => 'TH/DE_Spells',
];

// Collection from player data
$playerSpells = collect($player['spells'] ?? []);
@endphp

<div class="w-full text-white font-sans">
    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-6 shadow-lg shadow-black/30">
        <div class="absolute -top-12 -left-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="space-y-8">
            @foreach($groupedSpells as $category => $spellList)
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg sm:text-xl font-bold text-white">{{ $category }}</h2>
                        @php $owned = 0; $total = count($spellList); @endphp
                        @foreach($spellList as $spellName)
                            @php $data = $playerSpells->firstWhere('name', $spellName); if ($data) { $owned++; } @endphp
                        @endforeach
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-800/80 text-gray-300 ring-1 ring-white/10">{{ $owned }} / {{ $total }}</span>
                    </div>
                    <div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-4 sm:p-5 shadow-lg shadow-black/30">
                        <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                        @foreach($spellList as $spellName)
                            @php
                                $data = $playerSpells->firstWhere('name', $spellName);
                                $hasSpell = $data !== null;
                                $level = (int)($data['level'] ?? 0);

                                // Format name to image file
                                $imageName = str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $spellName) . '_info.webp';
                                $folder = $categoryFolders[$category] ?? 'TH/Other';
                                $imagePath = asset("images/{$folder}/{$imageName}");
                            @endphp

                            <div class="relative group flex flex-col items-center">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-900 ring-1 ring-white/10 p-1 shadow-lg shadow-black/30 flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
                                    <img src="{{ $imagePath }}" 
                                         alt="{{ $spellName }}" 
                                         class="w-full h-full rounded-full object-contain @if(!$hasSpell) grayscale opacity-40 @endif">
                                </div>
                                <div class="absolute -top-1 -right-1 flex items-center justify-center rounded-full w-7 h-7 text-[10px] font-extrabold 
                                            @if($hasSpell) bg-blue-600 text-white ring-1 ring-blue-300/40 @else bg-gray-700 text-gray-300 ring-1 ring-white/10 @endif">
                                    @if($hasSpell)
                                        <span>{{ $level }}</span>
                                    @else
                                        <span>Lv 0</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-[11px] text-gray-300 text-center truncate max-w-[6rem]">{{ $spellName }}</div>
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