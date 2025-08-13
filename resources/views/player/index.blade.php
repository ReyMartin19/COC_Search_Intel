@extends('layouts.layout')

@section('content')
<div class="min-h-screen bg-black text-white p-4 md:p-6 lg:p-8 font-sans max-w-7xl mx-auto">

    @isset($player)
        @php
            $league = determine_league($player['trophies']);
        @endphp

        {{-- Player Overview Card --}}
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-6 hover:shadow-blue-900/20 hover:shadow-xl transition-all duration-300">
            <div class="flex flex-col md:flex-row">
                {{-- Player Badge --}}
                <div class="w-full md:w-1/3 flex items-center justify-center p-6 bg-gray-900">
                    <img 
                        src="{{ asset('images/TH/Town_Hall' . $player['townHallLevel'] . '.webp') }}" 
                        alt="Town Hall {{ $player['townHallLevel'] }}" 
                        class="w-40 h-40 object-contain transform hover:scale-105 transition-transform duration-300"
                        loading="lazy" decoding="async"
                    />
                </div>

                {{-- Player Details --}}
                <div class="w-full md:w-2/3 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-blue-300">{{ $player['name'] }}</h1>
                            <p class="text-gray-400 mb-4">{{ $player['tag'] }}</p>
                        </div>
                        <div class="flex items-center bg-gray-900 px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-yellow-500 mr-1">star</span>
                            <span class="font-medium">XP Level {{ $player['expLevel'] }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-yellow-400 mr-2">home</span>
                            <div>
                                <div class="text-sm text-gray-400">Town Hall</div>
                                <div class="font-bold">Level {{ $player['townHallLevel'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-purple-400 mr-2">emoji_events</span>
                            <div>
                                <div class="text-sm text-gray-400">Trophies</div>
                                <div class="font-bold">{{ $player['trophies'] }} ({{ $league['name'] }})</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-yellow-500 mr-2">military_tech</span>
                            <div>
                                <div class="text-sm text-gray-400">War Stars</div>
                                <div class="font-bold">{{ $player['warStars'] ?? '0' }}</div>
                            </div>
                        </div>

                        @if(isset($player['clan']))
                        <div class="flex items-center col-span-2 md:col-span-3 mt-2 bg-gray-900/50 p-3 rounded-lg">
                            <img 
                                src="{{ asset('images/clans/' . strtolower($player['clan']['name']) . '.webp') }}" 
                                alt="{{ $player['clan']['name'] }}" 
                                class="w-10 h-10 mr-3"
                                onerror="this.style.display='none';"
                            />
                            <div>
                                <div class="text-sm text-gray-400">Clan</div>
                                <div class="font-bold text-blue-300">{{ $player['clan']['name'] }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Cards Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-7">
            {{-- Player Stats --}}
            <div class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-blue-900/20 hover:shadow-xl transition-all duration-300">
                <h2 class="text-xl font-bold mb-4 text-blue-300">Player Stats</h2>
                @include('player.partials.stats')
            </div>

            {{-- Clan Info --}}
            @if(isset($player['clan']))
            <div class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-blue-900/20 hover:shadow-xl transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-blue-300">Clan Information</h2>
                    <a href="{{ route('clan.show', ['tag' => ltrim($player['clan']['tag'], '#')]) }}"
                       class="bg-blue-600 hover:bg-blue-500 text-white text-xs px-3 py-1 rounded-full transition-colors duration-200">
                        View
                    </a>
                </div>
                @include('player.partials.clan_info')
            </div>
            @endif

            {{-- Builder Base --}}
            <div class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-blue-900/20 hover:shadow-xl transition-all duration-300">
                <h2 class="text-xl font-bold mb-4 text-blue-300">Builder Base</h2>
                @include('player.partials.builder_base_info')
            </div>
        </div>

        <!-- Heroes Section -->
        <div class="bg-gray-900 backdrop-blur-sm rounded-xl p-4 shadow-lg overflow-hidden mb-8">
            <div class="text-xl font-bold mb-4 text-primary-400 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">person</span>
                    Heroes
                </div>  
            </div>
            @include('player.partials.heroes')
        </div>

        <!-- Troops Section -->
        <div class="rounded-xl mb-8">
            @include('player.partials.troops')
        </div>

        <!-- Spells Section -->
        <div class="rounded-xl mb-8">
            @include('player.partials.spells')
        </div>

    @else
        @isset($error)
            <div class="bg-red-900/30 border border-red-700 rounded-xl p-6 text-center backdrop-blur-sm mt-10">
                <p class="text-red-300 font-medium">{{ $error }}</p>
            </div>
        @endisset
    @endisset
    
</div>
@endsection
