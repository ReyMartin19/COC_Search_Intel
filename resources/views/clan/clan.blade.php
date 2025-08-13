@extends('layouts.layout')

@section('content')

<div class="w-full min-h-screen text-white">
    <div class="max-w-7xl mx-auto px-6 py-8">

        @if (!empty($clan))
            @include('clan.partials.info', ['clan' => $clan])
            
            <!-- Tabs Navigation -->
            <div class="border-b border-gray-700 mb-8">
                <div class="flex space-x-1 justify-center">
                    @foreach (['members' => 'group', 'clan-war' => 'swords', 'cwl' => 'military_tech', 'history' => 'history'] as $id => $icon)
                        <button 
                            data-tab="{{ $id }}" 
                            class="tab-btn relative py-3 px-6 text-center font-medium text-sm text-gray-400 hover:text-white transition-all duration-300"
                        >
                            <span class="flex items-center justify-center gap-2 z-10 relative">
                                <span class="material-symbols-outlined">{{ $icon }}</span>
                                {{ ucfirst(str_replace('-', ' ', $id)) }}
                            </span>
                            <span class="absolute inset-0 bg-gray-800/50 rounded-t-lg opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tab Content -->    
            <div id="members-tab" class="tab-content">
                @include('clan.partials.tabs.members', ['clan' => $clan])
            </div>

            <div id="clan-war-tab" class="tab-content hidden">
                @include('clan.partials.tabs.war', ['clan' => $clan])
            </div>
            
            <div id="cwl-tab" class="tab-content hidden">
                @include('clan.partials.tabs.cwl', ['clan' => $clan])
            </div>

            <div id="history-tab" class="tab-content hidden">
                @include('clan.partials.tabs.history', ['clan' => $clan])
            </div>
        @else
            <div class="bg-gray-800 text-center text-gray-400 py-12 rounded-lg border border-gray-700">
                <p class="text-xl font-semibold">Clan data not available.</p>
                <p class="text-sm mt-2">Please search again or try later.</p>
            </div>
        @endif

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        if (!tabButtons.length || !tabContents.length) return;

        // Function to activate a tab
        const activateTab = (button) => {
            const tabId = button.getAttribute('data-tab') + '-tab';

            // Hide all tab contents
            tabContents.forEach(tab => tab.classList.add('hidden'));

            // Remove active styles from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('text-white', 'bg-gray-800/50', 'rounded-t-lg', 'border-b-2', 'border-blue-600');
                btn.classList.add('text-gray-400');
            });

            // Show selected tab
            const selectedTab = document.getElementById(tabId);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                } else {
                    console.error(`Tab content not found for: ${tabId}`);
                }

            // Activate current button
            button.classList.remove('text-gray-400');
            button.classList.add('text-white', 'bg-gray-800/50', 'rounded-t-lg', 'border-b-2', 'border-blue-600');
        };

        // Set up click handlers
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                activateTab(button);
                window.location.hash = button.getAttribute('data-tab');
            });
        });

        // Activate first tab by default if no hash in URL
        if (!window.location.hash) {
            activateTab(tabButtons[0]);
        } else {
            // Try to activate tab based on URL hash
            const hashTab = document.querySelector(`.tab-btn[data-tab="${window.location.hash.substring(1)}"]`);
            if (hashTab) {
                activateTab(hashTab);
            } else {
                activateTab(tabButtons[0]);
            }
        }
    });
</script>

<style>
    .tab-btn {
        margin-bottom: -1px;
        transition: all 0.3s ease;
    }
    .tab-content {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection