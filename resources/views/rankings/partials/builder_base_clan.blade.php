@php
    $isFullPage = $isFullPage ?? false;
    $limit = $isFullPage ? 50 : 5;
    $clans = collect($builderClanTop)->take($limit);
@endphp

@if($isFullPage)

<div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-5 shadow-lg shadow-black/30 mb-8">
    <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
    <div class="overflow-auto rounded-lg ring-1 ring-white/10 bg-gray-900/30">
        <table class="min-w-full text-sm text-gray-300">
            <thead class="bg-gray-800/70 sticky top-0 backdrop-blur supports-backdrop:backdrop-blur-sm">
                <tr>
                    <th class="px-4 py-3 text-left uppercase text-xs tracking-wider">Rank</th>
                    <th class="px-4 py-3 text-left uppercase text-xs tracking-wider">Clan Name</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider">Members</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider">Points</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @foreach($clans as $clan)
                    <tr class="hover:bg-gray-800/40 transition">
                        <td class="px-4 py-3 align-middle">
                            @if(($clan['rank'] ?? 0) <= 3)
                                @php $colors = ['from-yellow-400 to-amber-500','from-gray-300 to-gray-400','from-orange-300 to-amber-400']; @endphp
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $colors[($clan['rank']-1)] ?? 'from-gray-400 to-gray-500' }} inline-flex items-center justify-center text-gray-900 font-extrabold">{{ $clan['rank'] }}</div>
                            @else
                                <span class="text-gray-400 font-semibold">{{ $clan['rank'] }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap align-middle text-white font-semibold"><a href="{{ route('clan.show', ['tag' => ltrim($clan['tag'], '#')]) }}" class="hover:underline">{{ $clan['name'] }}</a></td>
                        <td class="px-4 py-3 text-center align-middle text-gray-200">{{ $clan['members'] }}/50</td>
                        <td class="px-4 py-3 text-center align-middle font-bold text-yellow-400">{{ $clan['clanBuilderBasePoints'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
    <div class="space-y-4 w-auto">
        <div class="flex items-center justify-between gap-8 mb-3">
            <h3 class="text-lg font-bold text-blue-400">Builder Base Top Clans</h3>
            <a href="{{ route('rankings') }}" class="text-xs font-medium text-blue-400 hover:text-white transition-colors duration-200 flex items-center group">
                View All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>         
        </div>
        
        @foreach($clans as $clan)
            <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg hover:bg-gray-800/70 transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <span class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center text-black font-bold text-sm"
                        >{{ $clan['rank'] }}
                    </span>
                    <span class="font-medium">{{ $clan['name'] }}</span>
                </div>
                <span class="text-yellow-400 font-bold">{{ $clan['clanBuilderBasePoints'] }}</span>
            </div>
        @endforeach
    </div>
@endif
