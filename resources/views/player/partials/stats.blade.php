<div class="space-y-4">
    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-red-500 mr-3">landscape</span>
            <span>Attack Wins</span>
        </div>
        <span class="font-bold">{{ $player['attackWins'] }}</span>
    </div>

    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-blue-500 mr-3">shield</span>
            <span>Defense Wins</span>
        </div>
        <span class="font-bold">{{ $player['defenseWins'] }}</span>
    </div>

    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-green-500 mr-3">arrow_upward</span>
            <span>Donations</span>
        </div>
        <span class="font-bold">{{ $player['donations'] ?? '0' }}</span>
    </div>

    <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg hover:bg-gray-900 transition">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-yellow-500 mr-3">arrow_downward</span>
            <span>Donations Received</span>
        </div>
        <span class="font-bold">{{ $player['donationsReceived'] ?? '0' }}</span>
    </div>
</div>
