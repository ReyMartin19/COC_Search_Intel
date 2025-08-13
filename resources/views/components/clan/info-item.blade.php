<div class="flex items-center justify-between bg-gray-800 p-4 rounded-xl shadow-sm">
    <div class="flex items-center space-x-3">
        <span class="material-symbols-outlined text-blue-400">
            {{ $icon }}
        </span>
        <span class="text-white font-semibold">{{ $label }}</span>
    </div>
    <div class="text-gray-300">
        {{ $value ?? '—' }}
    </div>
</div>
