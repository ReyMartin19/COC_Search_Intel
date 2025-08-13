@extends('layouts.layout')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="flex items-center justify-center gap-2 text-2xl font-bold mb-8 text-white">
        <img src="{{asset('images/TH/Icons/Trophy.webp')}}" alt="" class="h-[1em] w-[1em] mr-3" loading="lazy" decoding="async"> 
        Top Rankings
    </h2>
    {{-- Location Filter --}}
    <div class="mb-6 backdrop-blur-md bg-gradient-to-br from-gray-900/80 to-gray-800/80 rounded-xl p-5 shadow-lg border border-blue-500/20">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            
            {{-- Title --}}
            <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-2">
                <span class="material-symbols-outlined text-2xl">public</span>
                Location
            </h2>

            {{-- Filter Form --}}
            <form method="GET" action="" class="flex items-center gap-3 w-full md:w-auto" id="rankingsFilterForm">
                <div class="relative w-full md:w-56">
                    <input type="text" id="locationSearch" placeholder="Search location..."
                           class="w-full rounded-lg px-4 py-2.5 pr-10 bg-gray-900/80 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-colors shadow-md"
                           autocomplete="off" inputmode="search" enterkeyhint="search" spellcheck="false" autocapitalize="none" autocorrect="off"
                           role="combobox" aria-autocomplete="list" aria-haspopup="listbox" aria-expanded="false" aria-controls="locationList" aria-activedescendant="" aria-label="Choose location" aria-describedby="locationHelpText">
                    <p id="locationHelpText" class="sr-only">Type to filter locations. Use Arrow Up and Arrow Down to navigate, Enter to select, Escape to close.</p>
                    <input type="hidden" name="locationId" id="locationIdHidden" value="{{ $selectedLocationId ?? 'global' }}">

                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>

                    <ul id="locationList" class="hidden absolute z-10 mt-1 w-full max-h-60 overflow-auto rounded-md bg-gray-950 border border-gray-800/70 shadow-lg focus:outline-none" role="listbox" aria-label="Location options"></ul>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Responsive Tab Navigation --}}
    <div class="mb-8">
        <!-- Desktop Tabs -->
        <div class="hidden md:block border-b border-gray-700">
            <div class="flex space-x-1 justify-center">
                <button onclick="openTab('homePlayers')" class="tab-btn relative py-3 px-6 text-center font-medium text-sm text-gray-400 hover:text-white transition-all duration-300">
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <span class="material-symbols-outlined">home</span>
                        Home Players
                    </span>
                    <span class="absolute inset-0 bg-gray-800/50 rounded-t-lg opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                </button>
                <button onclick="openTab('builderPlayers')" class="tab-btn relative py-3 px-6 text-center font-medium text-sm text-gray-400 hover:text-white transition-all duration-300">
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <span class="material-symbols-outlined">construction</span>
                        Builder Players
                    </span>
                    <span class="absolute inset-0 bg-gray-800/50 rounded-t-lg opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                </button>
                <button onclick="openTab('homeClans')" class="tab-btn relative py-3 px-6 text-center font-medium text-sm text-gray-400 hover:text-white transition-all duration-300">
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <span class="material-symbols-outlined">shield</span>
                        Home Clans
                    </span>
                    <span class="absolute inset-0 bg-gray-800/50 rounded-t-lg opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                </button>
                <button onclick="openTab('builderClans')" class="tab-btn relative py-3 px-6 text-center font-medium text-sm text-gray-400 hover:text-white transition-all duration-300">
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <span class="material-symbols-outlined">handyman</span>
                        Builder Clans
                    </span>
                    <span class="absolute inset-0 bg-gray-800/50 rounded-t-lg opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                </button>
                <button onclick="openTab('capitalClans')" class="tab-btn relative py-3 px-6 text-center font-medium text-sm text-gray-400 hover:text-white transition-all duration-300">
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <span class="material-symbols-outlined">apartment</span>
                        Clan Capital
                    </span>
                    <span class="absolute inset-0 bg-gray-800/50 rounded-t-lg opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                </button>
            </div>
        </div>
        
        <!-- Mobile Dropdown -->
        <div class="md:hidden relative">
            <select id="mobileTabSelect" onchange="openTab(this.value)" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 text-white appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="homePlayers">🏠 Home Players</option>
                <option value="builderPlayers">🛠️ Builder Players</option>
                <option value="homeClans">🛡️ Home Clans</option>
                <option value="builderClans">🔨 Builder Clans</option>
                <option value="capitalClans">🏛️ Clan Capital</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

{{-- Searchable Location JS --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('locationSearch');
    const list = document.getElementById('locationList');
    const hidden = document.getElementById('locationIdHidden');
    const form = document.getElementById('rankingsFilterForm');

    // Data: Global + locations from server
    const locations = [{ id: 'global', name: 'Global' }, ...(@json($locations) || [])];

    // State
    let activeIndex = -1; // keyboard highlight index
    let itemsCache = locations.slice(0);
    let rafId = null;

    // Initialize input value to current selection
    const currentId = hidden.value || 'global';
    const current = locations.find(l => String(l.id) === String(currentId));
    if (current) input.value = current.name;

    function clearList() {
      while (list.firstChild) list.removeChild(list.firstChild);
    }

    function render(items) {
      clearList();
      if (!items.length) {
        const li = document.createElement('li');
        li.className = 'px-4 py-2 text-gray-400';
        li.textContent = 'No results';
        list.appendChild(li);
        return;
      }
      items.forEach((loc, idx) => {
        const li = document.createElement('li');
        li.id = `loc-opt-${String(loc.id).replace(/[^a-z0-9-_]/gi,'')}`;
        li.setAttribute('role', 'option');
        li.setAttribute('aria-selected', 'false');
        li.className = 'px-4 py-2 text-gray-100 hover:bg-gray-800/80 cursor-pointer';
        li.textContent = loc.name || '';
        li.addEventListener('mouseenter', () => setActive(idx));
        li.addEventListener('click', () => select(loc));
        list.appendChild(li);
      });
    }

    function setActive(index) {
      const children = list.children;
      if (!children.length) return;
      activeIndex = Math.max(0, Math.min(index, children.length - 1));
      for (let i = 0; i < children.length; i++) {
        const isActive = i === activeIndex;
        children[i].classList.toggle('bg-gray-800/80', isActive);
        children[i].setAttribute('aria-selected', isActive ? 'true' : 'false');
        if (isActive) input.setAttribute('aria-activedescendant', children[i].id);
      }
      // Ensure active stays in view without layout thrash
      const activeEl = children[activeIndex];
      if (activeEl) {
        const { top, bottom } = activeEl.getBoundingClientRect();
        const { top: lt, bottom: lb } = list.getBoundingClientRect();
        if (top < lt) activeEl.scrollIntoView({ block: 'nearest' });
        else if (bottom > lb) activeEl.scrollIntoView({ block: 'nearest' });
      }
    }

    function show() {
      list.classList.remove('hidden');
      input.setAttribute('aria-expanded', 'true');
    }
    function hide() {
      list.classList.add('hidden');
      input.setAttribute('aria-expanded', 'false');
      input.removeAttribute('aria-activedescendant');
      activeIndex = -1;
    }

    function select(loc) {
      hidden.value = loc.id;
      input.value = loc.name || '';
      hide();
      form.submit();
    }

    function doFilter() {
      const q = (input.value || '').trim().toLowerCase();
      itemsCache = q ? locations.filter(l => (l.name || '').toLowerCase().includes(q)) : locations;
      render(itemsCache);
      show();
      setActive(0);
    }

    // Minimal reflow: debounce via rAF
    function filterRaf() {
      if (rafId) cancelAnimationFrame(rafId);
      rafId = requestAnimationFrame(doFilter);
    }

    input.addEventListener('focus', doFilter);
    input.addEventListener('input', filterRaf);
    input.addEventListener('keydown', (e) => {
      const max = list.children.length - 1;
      if (e.key === 'Escape') { hide(); return; }
      if (e.key === 'ArrowDown') { e.preventDefault(); if (max >= 0) setActive(activeIndex < 0 ? 0 : Math.min(activeIndex + 1, max)); return; }
      if (e.key === 'ArrowUp') { e.preventDefault(); if (max >= 0) setActive(activeIndex <= 0 ? 0 : activeIndex - 1); return; }
      if (e.key === 'Enter') {
        e.preventDefault();
        if (activeIndex >= 0 && itemsCache[activeIndex]) { select(itemsCache[activeIndex]); return; }
        // Fallback: exact match or first contains
        const q = (input.value || '').toLowerCase();
        const match = locations.find(l => (l.name || '').toLowerCase() === q) || locations.find(l => (l.name || '').toLowerCase().includes(q));
        if (match) select(match);
      }
    });

    document.addEventListener('click', (e) => {
      if (!list.contains(e.target) && e.target !== input) hide();
    });
  });
</script>

{{-- Tab Content --}}
    <div id="homePlayers" class="tab-content">
        @include('rankings.partials.home_player', ['isFullPage' => true])
    </div>
    <div id="builderPlayers" class="tab-content hidden">
        @include('rankings.partials.builder_base_player', ['isFullPage' => true])
    </div>
    <div id="homeClans" class="tab-content hidden">
        @include('rankings.partials.home_clan', ['isFullPage' => true])
    </div>
    <div id="builderClans" class="tab-content hidden">
        @include('rankings.partials.builder_base_clan', ['isFullPage' => true])
    </div>
    <div id="capitalClans" class="tab-content hidden">
        @include('rankings.partials.clan_capital', ['isFullPage' => true])
    </div>
</div>

{{-- Tab Script --}}
<script>
    let currentTab = 'homePlayers'; // Track current tab
    
    function openTab(tabId) {
        // Update current tab
        currentTab = tabId;
        
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        // Show the selected one
        document.getElementById(tabId).classList.remove('hidden');

        // Update active tab style (desktop)
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-white', 'bg-gray-800/50', 'rounded-t-lg', 'border-b-2', 'border-blue-600');
            btn.classList.add('text-gray-400');
            
            // Reset the pseudo-background
            const bg = btn.querySelector('span:last-child');
            bg.classList.remove('opacity-100', 'border-b-2', 'border-white');
            bg.classList.add('opacity-0', 'hover:opacity-100');
        });
        
        // Add active style to current tab (desktop)
        const activeBtn = document.querySelector(`.tab-btn[onclick="openTab('${tabId}')"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-400', 'border-b-2', 'border-white');
            activeBtn.classList.add('text-white', 'bg-gray-800/50', 'rounded-t-lg', 'border-b-2', 'border-blue-600');
            
            // Show the background permanently for active tab
            const activeBg = activeBtn.querySelector('span:last-child');
            activeBg.classList.remove('opacity-0', 'hover:opacity-100', 'border-b-2', 'border-white');
            activeBg.classList.add('opacity-100');
        }

        // Update mobile dropdown selection
        const mobileSelect = document.getElementById('mobileTabSelect');
        if (mobileSelect) {
            mobileSelect.value = tabId;
        }
    }

    // Open default tab on load
    document.addEventListener('DOMContentLoaded', () => {
        // Check if there's a saved tab in localStorage
        const savedTab = localStorage.getItem('selectedTab');
        if (savedTab && document.getElementById(savedTab)) {
            openTab(savedTab);
        } else {
            openTab('homePlayers');
        }
        
        // Save tab selection when changed
        document.querySelectorAll('.tab-btn, #mobileTabSelect').forEach(el => {
            el.addEventListener('click', function() {
                if (this.id !== 'mobileTabSelect') {
                    localStorage.setItem('selectedTab', currentTab);
                }
            });
        });
    });
</script>

<style>
    .tab-btn {
        margin-bottom: -1px; /* Align with border */
        transition: all 0.3s ease;
    }
    .tab-content {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Style for mobile dropdown */
    #mobileTabSelect {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
@endsection