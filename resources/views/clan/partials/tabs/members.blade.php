<div class="relative overflow-hidden rounded-xl border border-gray-700/70 bg-gradient-to-br from-gray-900 to-gray-950 p-6 shadow-lg shadow-black/30 mb-8">
    <div class="absolute -top-12 -right-12 h-36 w-36 rounded-full bg-purple-500/10 blur-3xl"></div>
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h2 class="text-xl font-bold text-white">Members</h2>
        <div class="flex items-center gap-2">
            <span class="text-xs px-2 py-1 rounded-full bg-gray-800/80 text-gray-300 ring-1 ring-white/10">Total: {{ count($clan['memberList'] ?? []) }}</span>
            <select id="sortField" class="px-3 py-2 rounded-4xl bg-gray-800/60 text-white ring-1 ring-white/10 hover:bg-gray-800/80">
                <option value="">Default Order</option>
                <option value="name">Name</option>
                <option value="expLevel">XP</option>
                <option value="townHallLevel">TH</option>
                <option value="role">Role</option>
                <option value="trophies">Trophies</option>
                <option value="donationsReceived">Donations Received</option>
                <option value="donations">Donations</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg ring-1 ring-white/10 bg-gray-900/30">
        <table class="w-full text-left text-sm text-gray-300">
            <thead class="bg-gray-800/70 sticky top-0 backdrop-blur supports-backdrop:backdrop-blur-sm">
                <tr>
                    <th class="px-4 py-3 text-left uppercase text-xs tracking-wider text-gray-300">Member</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">XP</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">TH</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">Role</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">Trophies</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">Recv</th>
                    <th class="px-4 py-3 text-center uppercase text-xs tracking-wider text-gray-300">Donations</th>
                </tr>
            </thead>
            <tbody id="membersTableBody" class="divide-y divide-gray-800/80">
                @php
                    $roleClasses = [
                        'leader' => 'bg-yellow-600/20 text-yellow-300 ring-1 ring-yellow-400/30',
                        'coleader' => 'bg-purple-600/20 text-purple-300 ring-1 ring-purple-400/30',
                        'admin' => 'bg-indigo-600/20 text-indigo-300 ring-1 ring-indigo-400/30',
                        'member' => 'bg-gray-700/40 text-gray-300 ring-1 ring-white/10',
                    ];
                @endphp
                @foreach($clan['memberList'] as $member)
                    @php
                        $roleKey = strtolower($member['role'] ?? 'member');
                        $chipClass = $roleClasses[$roleKey] ?? $roleClasses['member'];
                        $th = $member['townHallLevel'] ?? null;
                        $recv = (int)($member['donationsReceived'] ?? 0);
                        $give = (int)($member['donations'] ?? 0);
                        $totalDon = max(1, $recv + $give);
                        $givePct = $totalDon > 0 ? ($give / $totalDon * 100) : 0;
                    @endphp
                    <tr class="hover:bg-gray-800/40 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-gray-800/60 ring-1 ring-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a6.5 6.5 0 0113 0"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">
                                        <a href="/player/{{ str_replace('#', '', $member['tag']) }}" class="text-blue-400 hover:underline">{{ $member['name'] }}</a>
                                    </div>
                                    <div class="text-xs text-gray-400">{{ $member['tag'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center align-middle text-gray-200">{{ $member['expLevel'] }}</td>
                        <td class="px-4 py-3 text-center align-middle">
                            @if($th)
                                <img src="{{ asset('images/TH/Town_Hall' . $th . '.webp') }}" alt="TH{{ $th }}" class="h-6 mx-auto" onerror="this.src='{{ asset('images/TH/Unknown.webp') }}'" loading="lazy" decoding="async">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center align-middle">
                            <span class="text-xs px-2 py-1 rounded-full {{ $chipClass }}">{{ ucfirst($member['role']) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center align-middle">
                            <div class="inline-flex items-center gap-1 font-semibold text-gray-200">
                                <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor"><path d="M3 12l9-9 9 9-9 9-9-9z"/></svg>
                                {{ number_format($member['trophies']) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center align-middle text-gray-300">{{ $recv }}</td>
                        <td class="px-4 py-3 text-center align-middle">
                            <div class="mx-auto w-28">
                                <div class="flex items-center justify-center gap-1 text-green-400 font-semibold">{{ $give }}</div>
                                <div class="mt-1 h-1.5 w-full rounded bg-gray-700">
                                    <div class="h-1.5 rounded bg-gradient-to-r from-emerald-400 to-green-400" style="width: {{ max(0,min(100,$givePct)) }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const members = @json($clan['memberList']);
        const tableBody = document.getElementById('membersTableBody');
        const sortField = document.getElementById('sortField');

        const roleClass = role => {
            const key = (role || 'member').toLowerCase();
            if (key === 'leader') return 'bg-yellow-600/20 text-yellow-300 ring-1 ring-yellow-400/30';
            if (key === 'coleader') return 'bg-purple-600/20 text-purple-300 ring-1 ring-purple-400/30';
            if (key === 'admin') return 'bg-indigo-600/20 text-indigo-300 ring-1 ring-indigo-400/30';
            return 'bg-gray-700/40 text-gray-300 ring-1 ring-white/10';
        };

        function renderTable(sortedMembers) {
            tableBody.innerHTML = '';
            sortedMembers.forEach(member => {
                const recv = Number(member.donationsReceived || 0);
                const give = Number(member.donations || 0);
                const total = Math.max(1, recv + give);
                const givePct = Math.max(0, Math.min(100, (give / total) * 100));

                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-800/40 transition';
                
                row.innerHTML = `
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-gray-800/60 ring-1 ring-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a6.5 6.5 0 0113 0"/></svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">
                                    <a href="/player/${member.tag.replace('#', '')}" class="text-blue-400 hover:underline">${member.name}</a>
                                </div>
                                <div class="text-xs text-gray-400">${member.tag}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center align-middle text-gray-200">${member.expLevel}</td>
                    <td class="px-4 py-3 text-center align-middle">
                        ${member.townHallLevel ? `<img src="/images/TH/Town_Hall${member.townHallLevel}.webp" alt="TH${member.townHallLevel}" class="h-6 mx-auto" onerror="this.src='/images/TH/Unknown.webp'" loading="lazy" decoding="async">` : '<span class="text-gray-400">-</span>'}
                    </td>
                    <td class="px-4 py-3 text-center align-middle">
                        <span class="text-xs px-2 py-1 rounded-full ${roleClass(member.role)}">${member.role.charAt(0).toUpperCase() + member.role.slice(1)}</span>
                    </td>
                    <td class="px-4 py-3 text-center align-middle">
                        <div class="inline-flex items-center gap-1 font-semibold text-gray-200">
                            <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor"><path d="M3 12l9-9 9 9-9 9-9-9z"/></svg>
                            ${Number(member.trophies || 0).toLocaleString()}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center align-middle text-gray-300">${recv}</td>
                    <td class="px-4 py-3 text-center align-middle">
                        <div class="mx-auto w-28">
                            <div class="flex items-center justify-center gap-1 text-green-400 font-semibold">${give}</div>
                            <div class="mt-1 h-1.5 w-full rounded bg-gray-700">
                                <div class="h-1.5 rounded bg-gradient-to-r from-emerald-400 to-green-400" style="width: ${givePct}%"></div>
                            </div>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        }

        function sortMembers() {
            const field = sortField.value;
            if (!field) { renderTable(members); return; }

            const sorted = [...members].sort((a, b) => {
                let valA = a[field];
                let valB = b[field];

                if (typeof valA === 'string') {
                    valA = valA.toLowerCase();
                    valB = valB.toLowerCase();
                }

                // Descending order
                if (valA < valB) return 1;
                if (valA > valB) return -1;
                return 0;
            });
            renderTable(sorted);
        }

        sortField.addEventListener('change', sortMembers);
        renderTable(members);
    });
</script>