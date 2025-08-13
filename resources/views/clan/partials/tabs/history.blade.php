<div class="bg-gray-800/50 rounded-lg p-6 mb-8" x-data="{ activeTab: 'regular' }">
    <h2 class="text-xl text-center font-bold mb-6 text-white">Clan History</h2>

    @php
        $regularWars = [];
        $cwlSeasons = [];
        
        // Process regular wars and CWL wars from war log
        if (isset($clan['warLog']['items']) && is_array($clan['warLog']['items'])) {
            foreach ($clan['warLog']['items'] as $log) {
                if (isset($log['attacksPerMember']) && $log['attacksPerMember'] == 1) {
                    // Group CWL wars by season (month)
                    $endTime = isset($log['endTime']) ? \Carbon\Carbon::createFromFormat('Ymd\THis.v\Z', $log['endTime']) : null;
                    $seasonKey = $endTime ? $endTime->format('Y-m') : 'unknown';
                    
                    if (!isset($cwlSeasons[$seasonKey])) {
                        $cwlSeasons[$seasonKey] = [
                            'logs' => [],
                            'endTime' => $endTime,
                            'isCurrent' => false
                        ];
                    }
                    $cwlSeasons[$seasonKey]['logs'][] = $log;
                } else {
                    $regularWars[] = $log;
                }
            }
        }
        
        // Process current CWL if available
        if (isset($clan['cwl']['rounds']) && is_array($clan['cwl']['rounds'])) {
            $currentSeason = [
                'logs' => [],
                'endTime' => null,
                'isCurrent' => true
            ];
            
            foreach ($clan['cwl']['rounds'] as $round) {
                if (isset($round['warTags']) && is_array($round['warTags'])) {
                    foreach ($round['warTags'] as $warTag) {
                        if ($warTag !== '#0' && isset($clan['cwlWars'][$warTag]) && is_array($clan['cwlWars'][$warTag])) {
                            $currentSeason['logs'][] = $clan['cwlWars'][$warTag];
                            // Set end time to the latest war's end time
                            if (isset($clan['cwlWars'][$warTag]['endTime'])) {
                                $warEndTime = \Carbon\Carbon::createFromFormat('Ymd\THis.v\Z', $clan['cwlWars'][$warTag]['endTime']);
                                if (!$currentSeason['endTime'] || $warEndTime->gt($currentSeason['endTime'])) {
                                    $currentSeason['endTime'] = $warEndTime;
                                }
                            }
                        }
                    }
                }
            }
            
            if (!empty($currentSeason['logs'])) {
                $seasonKey = $currentSeason['endTime'] ? $currentSeason['endTime']->format('Y-m') : 'current';
                $cwlSeasons[$seasonKey] = $currentSeason;
            }
        }
        
        // Sort seasons by date (newest first)
        uksort($cwlSeasons, function($a, $b) {
            if ($a === 'current') return -1;
            if ($b === 'current') return 1;
            return strtotime($b) <=> strtotime($a);
        });
    @endphp

    <!-- Tab Buttons -->
    <div class="flex justify-center space-x-4 mb-6">
        <button 
            @click="activeTab = 'regular'" 
            class="px-4 py-2 rounded-4xl font-semibold text-sm transition-colors duration-200 flex items-center gap-2"
            :class="activeTab === 'regular' ? 'bg-yellow-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
            </svg>
            Wars
        </button>
        <button 
            @click="activeTab = 'cwl'" 
            class="px-4 py-2 rounded-4xl font-semibold text-sm transition-colors duration-200 flex items-center gap-2"
            :class="activeTab === 'cwl' ? 'bg-purple-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            CWL
        </button>
    </div>

    <!-- Tab Content -->
    <div class="max-h-[500px] overflow-y-auto pr-2">
        <!-- Regular Clan Wars -->
        <div x-show="activeTab === 'regular'">
            @if(count($regularWars) > 0)
                <div class="space-y-4">
                    @foreach($regularWars as $log)
                        @include('clan.partials.history-tab.war-entry', [
                            'log' => $log,
                            'isCWL' => false,
                            'pageClanTag' => $clan['tag'] ?? null
                        ])
                    @endforeach
                </div>
            @else
                <p class="text-gray-400">No regular war history.</p>
            @endif
        </div>

        <!-- Clan War League (CWL) -->
        <div x-show="activeTab === 'cwl'" x-cloak>
            @if(count($cwlSeasons) > 0)
                <div class="space-y-6">
                    @foreach($cwlSeasons as $seasonKey => $season)
                        @php
                            $isCurrent = $season['isCurrent'] ?? false;
                            $seasonName = $isCurrent ? 'Current CWL' : ($season['endTime'] ? $season['endTime']->format('F Y') : 'Previous CWL');
                            $firstLog = $season['logs'][0] ?? null;

                            // When ongoing, aggregate our clan's stats across wars
                            // When completed, just use API's provided season summary/result from the log as-is
                            $aggregatedStats = null;
                            $aggregatedLog = $firstLog;

                            if ($isCurrent) {
                                $aggregatedStats = [
                                    'totalStars' => 0,
                                    'totalDestruction' => 0,
                                    'totalAttacks' => 0,
                                    'warCount' => 0,
                                    'teamSize' => 0,
                                    'endTime' => null,
                                    'ourClan' => null
                                ];

                                $pageClanTag = $clan['tag'] ?? '';

                                foreach ($season['logs'] as $log) {
                                    if (!is_array($log)) { continue; }

                                    $clanTagInLog = $log['clan']['tag'] ?? '';
                                    $opponentTagInLog = $log['opponent']['tag'] ?? '';

                                    if ($clanTagInLog === $pageClanTag) {
                                        $ourClanData = $log['clan'];
                                    } elseif ($opponentTagInLog === $pageClanTag) {
                                        $ourClanData = $log['opponent'];
                                    } else {
                                        continue;
                                    }

                                    $aggregatedStats['warCount']++;
                                    $aggregatedStats['totalStars'] += $ourClanData['stars'] ?? 0;
                                    $aggregatedStats['totalDestruction'] += $ourClanData['destructionPercentage'] ?? 0;
                                    $aggregatedStats['totalAttacks'] += $ourClanData['attacks'] ?? 0;
                                    $aggregatedStats['teamSize'] = $log['teamSize'] ?? $aggregatedStats['teamSize'];

                                    if (!$aggregatedStats['ourClan']) {
                                        $aggregatedStats['ourClan'] = $ourClanData;
                                    }

                                    if (isset($log['endTime'])) {
                                        $endTime = \Carbon\Carbon::createFromFormat('Ymd\THis.v\Z', $log['endTime']);
                                        if (!$aggregatedStats['endTime'] || $endTime->gt($aggregatedStats['endTime'])) {
                                            $aggregatedStats['endTime'] = $endTime;
                                        }
                                    }
                                }

                                $avgDestruction = $aggregatedStats['warCount'] > 0
                                    ? $aggregatedStats['totalDestruction'] / $aggregatedStats['warCount']
                                    : 0;

                                // Build aggregated log using the page clan's identity to avoid mismatches
                                $aggregatedLog = [
                                    'clan' => [
                                        'name' => $clan['name'] ?? ($aggregatedStats['ourClan']['name'] ?? 'Unknown'),
                                        'tag' => $pageClanTag,
                                        'badgeUrls' => $clan['badgeUrls'] ?? ($aggregatedStats['ourClan']['badgeUrls'] ?? ['small' => asset('images/default_badge.png')]),
                                        'stars' => $aggregatedStats['totalStars'],
                                        'destructionPercentage' => $avgDestruction,
                                        'attacks' => $aggregatedStats['totalAttacks']
                                    ],
                                    'teamSize' => $aggregatedStats['teamSize'],
                                    'endTime' => $aggregatedStats['endTime'] ? $aggregatedStats['endTime']->format('Ymd\\THis.v\\Z') : null,
                                    'warCount' => $aggregatedStats['warCount']
                                ];
                            }
                        @endphp
                        
                        <div>
                            <h3 class="text-md font-semibold text-gray-200 mb-3">
                                {{ $seasonName }}
                                @if($isCurrent)
                                    <span class="text-xs bg-blue-900 text-blue-300 px-2 py-1 rounded-full ml-2">Ongoing</span>
                                @endif
                            </h3>
                            
                            @if(($isCurrent && ($aggregatedLog['warCount'] ?? 0) > 0) || (!$isCurrent && $aggregatedLog))
                                @include('clan.partials.history-tab.war-entry', [
                                    'log' => $aggregatedLog,
                                    'isCWL' => true,
                                    'isCurrent' => $isCurrent,
                                    'isAggregated' => $isCurrent,
                                    'pageClanTag' => $clan['tag'] ?? null
                                ])
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400">No CWL history.</p>
            @endif
        </div>
    </div>
</div>