<div class="rounded-lg overflow-hidden shadow-xl p-4 md:p-6 space-y-6">
    @if (!empty($clan['description']))
        <div class="bg-gray-800 p-6 rounded-xl shadow-sm">
            <!-- Basic Clan Info -->
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                <!-- Clan Badge -->
                <div class="relative group">
                    <div class="w-24 h-24 md:w-32 md:h-32 p-4 rounded-full bg-gray-800 border-2 border-blue-500 flex items-center justify-center overflow-hidden transform transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-blue-500/20">
                        <img
                            src="{{ $clan['badgeUrls']['large'] }}"
                            alt="Clan Badge"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs md:text-sm font-bold rounded-full w-8 h-8 md:w-10 md:h-10 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                        <span>{{ $clan['clanLevel'] }}</span>
                    </div>
                </div>

                <!-- Clan Name, Tag, Description -->
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">{{ $clan['name'] }}</h1>
                    <p class="text-gray-400 text-sm md:text-base font-mono mb-2">{{ $clan['tag'] }}</p>
                    <p class="text-gray-300 text-sm md:text-base italic max-w-md">
                        {{ $clan['description'] ? $clan['description'] : 'No description provided.' }}
                    </p>
                </div>
            </div>

            <!-- Clan Stats -->
            <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="bg-gray-800/70 rounded-lg p-3 transition-all duration-300 hover:bg-gray-800 hover:shadow-md hover:shadow-blue-500/10">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Clan Points</p>
                    <p class="text-white text-lg font-semibold">{{ number_format($clan['clanPoints']) }}</p>
                </div>
                <div class="bg-gray-800/70 rounded-lg p-3 transition-all duration-300 hover:bg-gray-800 hover:shadow-md hover:shadow-blue-500/10">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Builder Base</p>
                    <p class="text-white text-lg font-semibold">{{ number_format($clan['clanBuilderBasePoints']) }}</p>
                </div>
                <div class="bg-gray-800/70 rounded-lg p-3 transition-all duration-300 hover:bg-gray-800 hover:shadow-md hover:shadow-blue-500/10">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Capital Points</p>
                    <p class="text-white text-lg font-semibold">{{ number_format($clan['clanCapitalPoints']) }}</p>
                </div>
                <div class="bg-gray-800/70 rounded-lg p-3 transition-all duration-300 hover:bg-gray-800 hover:shadow-md hover:shadow-blue-500/10">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Members</p>
                    <p class="text-white text-lg font-semibold">{{ $clan['members'] }}/50</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Clan Details Tabs --}}
    <div class="border-b border-gray-700">
        <nav class="flex space-x-6" id="clan-tabs">
            <button class="tab-button text-blue-400 border-b-2 border-blue-500 pb-2 px-1 font-medium transition-colors hover:text-blue-300" data-tab="requirements">Requirements</button>
            <button class="tab-button text-gray-400 pb-2 px-1 font-medium transition-colors hover:text-gray-300" data-tab="war-info">War Info</button>
            <button class="tab-button text-gray-400 pb-2 px-1 font-medium transition-colors hover:text-gray-300" data-tab="general-info">General Info</button>
        </nav>
    </div>
    
    {{-- Tab Content --}}
    <div id="tab-content">
        {{-- Requirements Tab --}}
        <div class="tab-panel active grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="requirements-tab">
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-yellow-500 text-2xl">emoji_events</span>
                <div>
                    <p class="text-gray-400 text-xs">Required Trophies</p>
                    <p class="text-white font-medium">{{ $clan['requiredTrophies'] }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-blue-400 text-2xl">stadia_controller</span>
                <div>
                    <p class="text-gray-400 text-xs">Required Versus Trophies</p>
                    <p class="text-white font-medium">{{ $clan['requiredBuilderBaseTrophies'] }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-gray-300 text-2xl">location_city</span>
                <div>
                    <p class="text-gray-400 text-xs">Required Townhall Level</p>
                    <p class="text-white font-medium">{{ $clan['requiredTownhallLevel'] }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-purple-400 text-2xl">military_tech</span>
                <div>
                    <p class="text-gray-400 text-xs">Minimum Clan Level</p>
                    <p class="text-white font-medium">{{ $clan['clanLevel'] }}</p>
                </div>
            </div>
        </div>

        {{-- War Info Tab --}}
        <div class="tab-panel hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="war-info-tab">
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-orange-400 text-2xl">military_tech</span>
                <div>
                    <p class="text-gray-400 text-xs">War League</p>
                    <p class="text-white font-medium">{{ $clan['warLeague']['name'] ?? '—' }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-blue-400 text-2xl">schedule</span>
                <div>
                    <p class="text-gray-400 text-xs">War Frequency</p>
                    <p class="text-white font-medium">{{ $clan['warFrequency'] }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-green-400 text-2xl">verified</span>
                <div>
                    <p class="text-gray-400 text-xs">War Log Public</p>
                    <p class="text-white font-medium">{{ $clan['isWarLogPublic'] ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>

        {{-- General Info Tab --}}
        <div class="tab-panel hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="general-info-tab">
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-red-400 text-2xl">flag</span>
                <div>
                    <p class="text-gray-400 text-xs">Location</p>
                    <p class="text-white font-medium">{{ $clan['location']['name'] ?? '—' }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-blue-400 text-2xl">shield</span>
                <div>
                    <p class="text-gray-400 text-xs">Type</p>
                    <p class="text-white font-medium">{{ ucfirst($clan['type']) }}</p>
                </div>
            </div>
            <div class="bg-gray-800/50 rounded-lg p-4 flex items-center gap-3 transition-transform duration-300 hover:translate-y-[-2px]">
                <span class="material-symbols-outlined text-green-400 text-2xl">family_restroom</span>
                <div>
                    <p class="text-gray-400 text-xs">Family Friendly</p>
                    <p class="text-white font-medium">{{ $clan['isFamilyFriendly'] ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Description read more/less
            const desc = document.getElementById('clan-description');
            if (desc && desc.textContent.length > 300) {
                const original = desc.textContent;
                desc.textContent = original.slice(0, 300) + '...';
                
                const btn = document.createElement('button');
                btn.textContent = 'Read More';
                btn.className = 'ml-2 text-blue-400 underline text-sm';
                btn.onclick = function () {
                    desc.textContent = original;
                    btn.remove();
                };
                desc.insertAdjacentElement('afterend', btn);
            }

            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabPanels = document.querySelectorAll('.tab-panel');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active state from all buttons and panels
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-blue-400', 'border-b-2', 'border-blue-500');
                        btn.classList.add('text-gray-400');
                    });
                    
                    tabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                        panel.classList.remove('active');
                    });
                    
                    // Add active state to clicked button
                    button.classList.add('text-blue-400', 'border-b-2', 'border-blue-500');
                    button.classList.remove('text-gray-400');
                    
                    // Show corresponding panel
                    const tabId = button.getAttribute('data-tab') + '-tab';
                    const activePanel = document.getElementById(tabId);
                    if (activePanel) {
                        activePanel.classList.remove('hidden');
                        activePanel.classList.add('active');
                    }
                });
            });
        });
    </script>
</div>