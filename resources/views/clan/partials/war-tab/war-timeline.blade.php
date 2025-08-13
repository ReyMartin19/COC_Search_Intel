@php
    use Carbon\Carbon;

    function safeParseDate($dateString) {
        if (empty($dateString)) {
            return null;
        }
        try {
            return Carbon::createFromFormat('Ymd\THis.v\Z', $dateString)->setTimezone('UTC');
        } catch (\Exception $e) {
            return null;
        }
    }

    $prepStart = safeParseDate($war['preparationStartTime'] ?? null);
    $startTime = safeParseDate($war['startTime'] ?? null);
    $endTime   = safeParseDate($war['endTime'] ?? null);

    $phaseLabel = $isPreparation ? 'Preparation Phase' : ($isInWar ? 'Battle Day' : 'War Ended');
    $phaseColor = $isPreparation ? 'text-yellow-400' : ($isInWar ? 'text-red-400' : 'text-green-400');
    $phaseIcon  = $isPreparation ? 'hourglass_empty' : ($isInWar ? 'swords' : 'flag');
@endphp

<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-lg p-5 border border-purple-500/30 shadow-md backdrop-blur-sm">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-gray-300 text-base font-semibold uppercase tracking-wide">Timeline</h3>
    </div>

    <div class="space-y-3">
        <div class="flex justify-between items-center">
            <span class="flex items-center gap-2 text-gray-400">
                Match On:
            </span>
            <span class="text-white font-medium">
                {{ $prepStart ? $prepStart->format('M j, Y • g:i A') : '—' }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="flex items-center gap-2 text-gray-400">
                Starts On:
            </span>
            <span class="text-white font-medium">
                {{ $startTime ? $startTime->format('M j, Y • g:i A') : '—' }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="flex items-center gap-2 text-gray-400">
                Ends On:
            </span>
            <span class="text-white font-medium">
                @if($isInWar)
                    Ongoing
                @else
                    {{ $endTime ? $endTime->format('M j, Y • g:i A') : '—' }}
                @endif
            </span>
        </div>
    </div>
</div>
