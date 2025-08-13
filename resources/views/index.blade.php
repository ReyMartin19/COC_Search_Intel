@extends('layouts.layout')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-16">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6 bg-gradient-to-r from-white to-blue-400 bg-clip-text text-transparent">
            Clash of Clans Search Intel
        </h1>
        <p class="text-xl text-gray-300 mb-12">Search for players or clans by tag or name. Find about player's stats, <br>
            clan deatils, war match info, and clan war league match info.
        </p>
        
        {{-- Search form --}}
        <form id="searchForm" class="max-w-2xl mx-auto" action="{{ route('search') }}" method="POST">
            @csrf
            <div class="flex flex-col sm:flex-row items-center bg-gray-900/50 backdrop-blur-sm rounded-full border border-blue-500/30 p-2 hover:border-blue-500/60 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/20">
                <input 
                    type="text" 
                    name="tag"
                    placeholder="Enter player tag (#88JY8P2) or clan tag/name"
                    autocomplete="off"
                    class="flex-1 bg-transparent px-4 sm:px-6 py-3 text-white placeholder-gray-400 focus:outline-none w-full"
                    required
                >
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/30 flex items-center space-x-2">
                    <span class="material-symbols-outlined">search</span>
                    <span>Search</span>
                </button>
            </div>
            <p class="text-gray-400 mt-2 text-sm">
                Tip: Use #tag for exact matches, or name for clan searches
            </p>
        </form>
    </div>

    {{-- Loader Overlay --}}
    <div id="loaderOverlay" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 hidden">
        <span class="loader"></span>
    </div>

    {{-- Rankings section --}}
    @include('rankings.rankings')
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('searchForm');
        const loader = document.getElementById('loaderOverlay');

        form.addEventListener('submit', () => {
            loader.classList.remove('hidden');
        });

        const searchTypeInput = document.getElementById('searchType');
        const searchInput = document.getElementById('searchInput');

        const buttons = {
            player: document.getElementById('playerBtn'),
            clan: document.getElementById('clanBtn'),
            cwl: document.getElementById('cwlBtn')
        };

        Object.entries(buttons).forEach(([type, btn]) => {
            btn.addEventListener('click', () => {
                searchTypeInput.value = type;

                if (type === 'player') {
                    searchInput.placeholder = 'Player Tag (88JY8P2)';
                } else if (type === 'clan') {
                    searchInput.placeholder = 'Clan Tag / Name';
                } else if (type === 'cwl') {
                    searchInput.placeholder = 'Clan Tag (CWL Match)';
                }

                Object.values(buttons).forEach(b => b.classList.remove('active-tab'));
                btn.classList.add('active-tab');
            });
        });
    });
</script>

{{-- Styles --}}
<style>
    .search-toggle {
        @apply hover:bg-gray-800/50 transition-all;
    }

    .active-tab {
        @apply text-blue-400;
    }

    /* Loader Styles */
    .loader {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 6rem;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .loader:before,
    .loader:after {
        content: "";
        position: absolute;
        border-radius: 50%;
        animation: pulsOut 1.8s ease-in-out infinite;
        filter: drop-shadow(0 0 1rem rgba(255, 255, 255, 0.75));
    }

    .loader:before {
        width: 100%;
        padding-bottom: 100%;
        box-shadow: inset 0 0 0 1rem #fff;
        animation-name: pulsIn;
    }

    .loader:after {
        width: calc(100% - 2rem);
        padding-bottom: calc(100% - 2rem);
        box-shadow: 0 0 0 0 #fff;
    }

    @keyframes pulsIn {
        0% {
            box-shadow: inset 0 0 0 1rem #fff;
            opacity: 1;
        }
        50%, 100% {
            box-shadow: inset 0 0 0 0 #fff;
            opacity: 0;
        }
    }

    @keyframes pulsOut {
        0%, 50% {
            box-shadow: 0 0 0 0 #fff;
            opacity: 0;
        }
        100% {
            box-shadow: 0 0 0 1rem #fff;
            opacity: 1;
        }
    }
</style>
@endsection
