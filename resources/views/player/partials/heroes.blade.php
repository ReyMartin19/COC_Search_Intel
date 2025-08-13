@isset($player)
    @php
        $heroEquipMap = [
            'Barbarian King' => ['Barbarian Puppet', 'Rage Vial', 'Earthquake Boots', 'Vampstache', 'Giant Gauntlet', 'Spiky Ball', 'Snake Bracelet'],
            'Archer Queen' => ['Archer Puppet', 'Invisibility Vial', 'Giant Arrow', 'Healer Puppet', 'Frozen Arrow', 'Magic Mirror', 'Action Figure'],
            'Minion Prince' => ['Henchmen Puppet', 'Dark Orb', 'Metal Pants', 'Noble Iron', 'Dark Crown'],
            'Grand Warden' => ['Eternal Tome', 'Life Gem', 'Rage Gem', 'Healing Tome', 'Fireball', 'Lavaloon Puppet'],
            'Royal Champion' => ['Royal Gem', 'Seeking Shield', 'Hog Rider Puppet', 'Haste Vial', 'Rocket Spear', 'Electro Boots'],
            // Battle Machine and Copter do not have equipment
        ];

        $heroImageFolders = [
            'Barbarian King' => 'BK',
            'Archer Queen' => 'Q',
            'Grand Warden' => 'W',
            'Royal Champion' => 'RC',
            'Minion Prince' => 'MP',
            'Battle Machine' => 'BM',
            'Battle Copter' => 'BC',
        ];

        $allOwnedEquip = collect($player['heroEquipment'] ?? []);
        $normalHeroes = [];
        $otherHeroes = [];

        foreach ($player['heroes'] as $hero) {
            if (array_key_exists($hero['name'], $heroEquipMap)) {
                $normalHeroes[] = $hero;
            } else {
                $otherHeroes[] = $hero; // Battle Machine, Copter, etc.
            }
        }
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {{-- Heroes with equipment first --}}
        @foreach(array_merge($normalHeroes, $otherHeroes) as $hero)
            @php
                $name = $hero['name'];
                $allowedEquipment = $heroEquipMap[$name] ?? [];
                $heroLevel = $hero['level'] ?? '?';
                $folder = $heroImageFolders[$name] ?? 'BK';
                $gradient = match($name) {
                    'Barbarian King' => 'from-blue-500 to-blue-600',
                    'Archer Queen' => 'from-pink-500 to-pink-600',
                    'Grand Warden' => 'from-yellow-500 to-yellow-600',
                    'Royal Champion' => 'from-purple-500 to-purple-600',
                    'Minion Prince' => 'from-gray-600 to-gray-700',
                    'Battle Machine' => 'from-green-700 to-green-800',
                    'Battle Copter' => 'from-amber-600 to-amber-700',
                    default => 'from-blue-500 to-blue-600'
                };
            @endphp

            <div class=" bg-gradient-to-b from-gray-800 to-gray-900 rounded-2xl p-6 shadow-2xl hover:scale-[1.02] hover:shadow-blue-500/20 transition-all duration-300 group">
                <div class="relative mb-4">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br {{ $gradient }} p-1 shadow-lg">
                        <img src="{{ asset('images/TH/Heroes/' . str_replace(' ', '_', strtolower($name)) . '.webp') }}"
                             alt="{{ $name }}"
                             class="w-full h-full rounded-full object-cover" loading="lazy" decoding="async"/>
                    </div>
                    <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-sm font-bold px-2 py-1 rounded-full">
                        {{ $heroLevel }}
                    </div>
                </div>

                <h3 class="text-white font-bold text-lg text-center mb-4">{{ $name }}</h3>

                @if(!empty($allowedEquipment))
                    <div class="border-t border-gray-600 pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-gray-300 font-semibold text-sm">Equipment</h4>
                            @php
                                $equippedCount = $allOwnedEquip->filter(fn($e) => in_array($e['name'], $allowedEquipment) && $e['level'] >= 1)->count();
                            @endphp
                            <div class="text-xs text-gray-400">{{ $equippedCount }}/{{ count($allowedEquipment) }} Equipped</div>
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            @foreach($allowedEquipment as $equipName)
                                @php
                                    $equip = $allOwnedEquip->firstWhere('name', $equipName);
                                    $hasEquip = $equip && $equip['level'] >= 1;
                                    $level = $equip['level'] ?? 0;
                                    $imagePath = asset("images/TH/Equipment/{$folder}/" . str_replace(' ', '_', $equipName) . ".webp");
                                @endphp

                                <div class="relative group flex flex-col items-center">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gray-800 p-1 shadow-md flex items-center justify-center
                                        @if($hasEquip)
                                            border-2 border-blue-500 group-hover:border-blue-400 group-hover:shadow-blue-500/30
                                            transition-all duration-300 group-hover:scale-105
                                        @else opacity-60
                                        @endif">
                                        <img src="{{ $imagePath }}"
                                             alt="Equipment"
                                             class="w-full h-full rounded-full object-contain
                                                    @if(!$hasEquip) grayscale opacity-50 @endif" loading="lazy" decoding="async">
                                    </div>
                                    <div class="absolute -top-1 -right-1
                                                @if($hasEquip) bg-blue-500 @else bg-gray-600 @endif
                                                text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                        {{ $hasEquip ? $level : 0 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-400 text-sm mt-4">No equipment</p>
                @endif
            </div>
        @endforeach
    </div>
@endisset
