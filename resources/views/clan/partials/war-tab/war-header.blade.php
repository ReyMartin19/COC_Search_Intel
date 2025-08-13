<div class="flex justify-between items-center border-b border-purple-500/30 pb-4 mb-6">
    <h2 class="text-2xl font-bold text-white tracking-tight">Clan War</h2>
    <span class="px-3 py-1 bg-purple-500/20 rounded-md text-purple-300 font-medium text-sm border border-purple-500/40 hover:bg-purple-500/30 transition-colors">
        @if($isPreparation) PREPARATION
        @elseif($isInWar) BATTLE DAY
        @else WAR ENDED @endif
    </span>
</div>