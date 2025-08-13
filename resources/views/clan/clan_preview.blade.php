@extends('layouts.layout')

@section('content')

<div class="max-w-7xl mx-auto mt-6 mb-8 px-4 sm:px-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm">Back</span>
        </a>
        <h2 class="text-2xl font-bold text-white">Search Results</h2>
        <div class="w-16"></div>
    </div>

    {{-- Results --}}
    @if(isset($error))
        <div class="bg-red-900/30 border border-red-700 rounded-xl p-6 text-center backdrop-blur-sm">
            <p class="text-red-300 font-medium">{{ $error }}</p>
        </div>
    @elseif(count($clans) === 0)
        <div class="bg-gray-800/30 border border-gray-700 rounded-xl p-6 text-center backdrop-blur-sm">
            <p class="text-gray-400">No clans found matching your search</p>
        </div>
    @else
        {{-- Clan Grid --}}
        <div id="clan-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5"></div>

        {{-- Show More Button --}}
        <div class="text-center mt-8">
            <button id="show-more-btn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all shadow-lg hover:shadow-blue-500/30">
                Show More
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const clans = @json($clans);
                const grid = document.getElementById('clan-grid');
                const showMoreBtn = document.getElementById('show-more-btn');
                const batchSize = 8;
                let currentIndex = 0;

                function renderClans() {
                    const nextBatch = clans.slice(currentIndex, currentIndex + batchSize);

                    nextBatch.forEach(clan => {
                        const card = document.createElement('div');
                        card.className = 'bg-gradient-to-br from-gray-800/50 to-gray-900/70 border border-gray-700 rounded-xl p-5 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 backdrop-blur-sm flex flex-col group';

                        card.innerHTML = `
                            <div class="flex items-start mb-4">
                                <div class="relative">
                                    <img src="${clan.badgeUrls.small}" alt="Clan Badge" class="w-16 h-16 object-contain bg-gray-800 rounded-full p-1 border-2 border-gray-700 group-hover:border-blue-500 transition-colors" loading="lazy" decoding="async">
                                    <span class="absolute -bottom-1 -right-1 bg-yellow-500 text-black text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center border-2 border-gray-900">
                                        ${clan.clanLevel}
                                    </span>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-white truncate" title="${clan.name}">${clan.name}</h3>
                                    <span class="text-blue-400 text-sm font-mono">${clan.tag}</span>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded">
                                            Lvl ${clan.clanLevel}
                                        </span>
                                        <span class="ml-2 text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded">
                                            ${clan.type.replace(/([A-Z])/g, ' $1').trim()}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-3 mb-5">
                                <div class="bg-gray-800/50 rounded-lg p-2 text-center">
                                    <p class="text-gray-400 text-xs">Members</p>
                                    <p class="text-white font-bold">${clan.members}/50</p>
                                </div>
                                <div class="bg-gray-800/50 rounded-lg p-2 text-center">
                                    <p class="text-gray-400 text-xs">Points</p>
                                    <p class="text-yellow-400 font-bold">${clan.clanPoints.toLocaleString()}</p>
                                </div>
                                <div class="bg-gray-800/50 rounded-lg p-2 text-center">
                                    <p class="text-gray-400 text-xs">Wars</p>
                                    <p class="text-white font-bold">${clan.warWins || 'N/A'}</p>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-2">
                                <a href="/clan/${clan.tag.replace('#', '')}" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white text-center py-2.5 rounded-lg text-sm font-medium transition-all shadow-md hover:shadow-blue-500/40">
                                    View Clan
                                </a>
                            </div>
                        `;
                        grid.appendChild(card);
                    });

                    currentIndex += batchSize;

                    if (currentIndex >= clans.length) {
                        showMoreBtn.style.display = 'none';
                    }
                }

                // Initial render
                renderClans();

                // On click
                showMoreBtn.addEventListener('click', renderClans);
            });
        </script>
    @endif
</div>

@endsection