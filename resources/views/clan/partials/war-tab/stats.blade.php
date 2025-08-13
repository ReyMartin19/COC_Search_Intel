@isset($war)
    @php
        // Count TH levels for each clan
        $homeThCounts = array_count_values(array_column($war['clan']['members'], 'townhallLevel'));
        $awayThCounts = array_count_values(array_column($war['opponent']['members'], 'townhallLevel'));

        // Get all unique TH levels from both clans
        $allThLevels = array_unique(array_merge(
            array_keys($homeThCounts),
            array_keys($awayThCounts)
        ));
        rsort($allThLevels); // Sort from highest to lowest
    @endphp

    <div class="bg-gray-750 rounded-lg p-4 border border-gray-600 mt-6">
        <h3 class="font-bold text-lg mb-4 flex items-center justify-center">
            <span class="material-symbols-outlined mr-2">analytics</span>
            Town Hall Comparison
        </h3>

        <div class="space-y-4">
            @foreach($allThLevels as $thLevel)
                @php
                    $homeCount = $homeThCounts[$thLevel] ?? 0;
                    $awayCount = $awayThCounts[$thLevel] ?? 0;
                    $total = max($homeCount + $awayCount, 1); // Prevent division by zero
                    $homePercent = ($homeCount / $total) * 100;
                    $awayPercent = ($awayCount / $total) * 100;
                @endphp

                <div class="mb-3">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center w-1/4">
                            <span class="font-medium text-right mr-2">{{ $homeCount }}</span>
                            <img src="{{ asset('images/TH/Town_Hall' . $thLevel . '.webp') }}" 
                                alt="TH{{ $thLevel }}" 
                                class="w-6 h-6" loading="lazy" decoding="async">
                        </div>
                        
                        <div class="w-2/4 px-2">
                            <div class="flex h-3 bg-gray-700 rounded-full overflow-hidden">
                                <div class="bg-blue-500" style="width: {{ $homePercent }}%"></div>
                                <div class="bg-red-500" style="width: {{ $awayPercent }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end w-1/4">
                            <img src="{{ asset('images/TH/Town_Hall' . $thLevel . '.webp') }}" 
                                alt="TH{{ $thLevel }}" 
                                class="w-6 h-6 mr-2" loading="lazy" decoding="async">
                            <span class="font-medium">{{ $awayCount }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between text-xs text-gray-400 px-1">
                        <span>{{ round($homePercent) }}%</span>
                        <span>TH{{ $thLevel }}</span>
                        <span>{{ round($awayPercent) }}%</span>
                    </div>
                </div>
            @endforeach

            <!-- Summary Stats -->
            <div class="grid grid-cols-3 gap-4 mt-6 pt-4 border-t border-gray-600">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-400">
                        {{ array_sum($homeThCounts) }}
                    </div>
                    <div class="text-sm text-gray-400">Total Members</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">
                        {{ round(array_sum(array_keys($homeThCounts)) / max(1, count($homeThCounts)), 1) }}
                    </div>
                    <div class="text-sm text-gray-400">Avg. TH Level</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-400">
                        {{ array_sum($awayThCounts) }}
                    </div>
                    <div class="text-sm text-gray-400">Total Members</div>
                </div>
            </div>
        </div>
    </div>
@endisset