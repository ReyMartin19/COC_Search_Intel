@php
    $warId = 'war-' . md5($war['clan']['name'] . $war['opponent']['name']);
@endphp

<div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 shadow-lg shadow-black/30 mb-5">
    <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
    @include('clan.partials.cwl-tab._header', ['war' => $war, 'warId' => $warId])
    <div id="{{ $warId }}" class="hidden px-4 sm:px-6 pb-5">
        @include('clan.partials.cwl-tab._summary', ['war' => $war])
        @include('clan.partials.cwl-tab._clan-members', ['war' => $war])
        @include('clan.partials.cwl-tab._opponent-members', ['war' => $war])
    </div>
</div>