<div class="space-y-4 py-2">

    {{-- Filtros --}}
    <div class="flex gap-2">
        <div class="flex-1">
            <input
                wire:model.live.debounce.300ms="search"
                type="search"
                placeholder="Buscar máquina..."
                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
            >
        </div>
        <div>
            <input
                wire:model.live="dateFilter"
                type="date"
                class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-sm text-slate-300
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
            >
        </div>
    </div>

    {{-- Lista de sessões --}}
    @forelse($sessions as $session)
        <a href="{{ route('session.detail', $session->id) }}"
           class="block bg-slate-900 border border-slate-800 rounded-2xl p-4 hover:border-slate-600 active:scale-[0.99]
                  transition-all duration-150 group">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-2 h-2 rounded-full {{ $session->report ? 'bg-emerald-400' : 'bg-yellow-400' }}"></div>
                        <p class="text-xs text-slate-500 font-medium">
                            {{ $session->report ? 'Relatório completo' : 'Aguardando relatório' }}
                        </p>
                    </div>
                    <h3 class="font-semibold text-white truncate">{{ $session->machine_name }}</h3>
                    @if($session->machine_id)
                        <span class="text-xs text-cyan-500 font-mono">{{ $session->machine_id }}</span>
                    @endif
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $session->started_at->format('d/m/Y') }} • {{ $session->started_at->format('H:i') }} – {{ optional($session->finished_at)->format('H:i') }}
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-lg font-bold text-orange-400 font-mono">{{ $session->duration_formatted }}</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-600 group-hover:text-slate-400 ml-auto mt-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
    @empty
        <div class="flex flex-col items-center gap-3 py-16 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-slate-500 text-sm">Nenhum atendimento encontrado</p>
        </div>
    @endforelse

    {{-- Paginação --}}
    @if($sessions->hasPages())
        <div class="pt-2">
            {{ $sessions->links() }}
        </div>
    @endif

</div>
