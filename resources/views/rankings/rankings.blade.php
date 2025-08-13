<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-16">
    {{-- Home Village Top 5 --}}
    <div class="bg-gray-900/30 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-800 p-4 sm:p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10">
        @include('rankings.partials.home_player')
    </div>

    {{-- Builder Base Top 5 --}}
    <div class="bg-gray-900/30 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-800 p-4 sm:p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10">
        @include('rankings.partials.builder_base_player')
    </div>

    {{-- Clan trophies --}}
    <div class="bg-gray-900/30 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-800 p-4 sm:p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10">
        @include('rankings.partials.home_clan')
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
    {{-- Builder Base Clan trophies --}}
    <div class="bg-gray-900/30 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-800 p-4 sm:p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10">
        @include('rankings.partials.builder_base_clan')
    </div>

    {{-- Clan Capital Top --}}
    <div class="bg-gray-900/30 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-800 p-4 sm:p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10">
        @include('rankings.partials.clan_capital')
    </div>
</div>