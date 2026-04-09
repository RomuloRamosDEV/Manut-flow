<div class="space-y-5 py-2">

    {{-- Cabeçalho --}}
    <a href="{{ route('history') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-slate-200 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar ao histórico
    </a>

    {{-- Card: info da sessão --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-4">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
            <span class="text-xs font-semibold uppercase tracking-widest text-slate-400">Atendimento</span>
        </div>

        <div>
            <h2 class="text-xl font-bold text-white">{{ $session->machine_name }}</h2>
            @if($session->machine_id)
                <span class="text-xs text-cyan-500 font-mono bg-cyan-500/10 px-2 py-0.5 rounded-full mt-1 inline-block">{{ $session->machine_id }}</span>
            @endif
        </div>

        <div class="grid grid-cols-3 gap-3">
            <div class="bg-slate-800 rounded-xl p-3">
                <p class="text-xs text-slate-500 mb-1">Duração</p>
                <p class="text-lg font-bold text-orange-400 font-mono">{{ $session->duration_formatted }}</p>
            </div>
            <div class="bg-slate-800 rounded-xl p-3">
                <p class="text-xs text-slate-500 mb-1">Início</p>
                <p class="text-sm font-semibold text-slate-200">{{ $session->started_at->format('H:i') }}</p>
            </div>
            <div class="bg-slate-800 rounded-xl p-3">
                <p class="text-xs text-slate-500 mb-1">Fim</p>
                <p class="text-sm font-semibold text-slate-200">{{ optional($session->finished_at)->format('H:i') ?? '—' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2 pt-1 border-t border-slate-800">
            <div class="w-7 h-7 rounded-full bg-cyan-700 flex items-center justify-center text-xs font-bold text-white uppercase">
                {{ $session->user->initials() }}
            </div>
            <div>
                <p class="text-sm font-medium text-slate-200">{{ $session->user->name }}</p>
                <p class="text-xs text-slate-500">{{ $session->started_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Card: relatório --}}
    @if($session->report)
        <div class="space-y-4">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Relatório
            </h3>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Problema Encontrado</p>
                    <p class="text-sm text-slate-200 leading-relaxed whitespace-pre-line">{{ $session->report->problem_description }}</p>
                </div>
                <div class="border-t border-slate-800 pt-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Solução Aplicada</p>
                    <p class="text-sm text-slate-200 leading-relaxed whitespace-pre-line">{{ $session->report->solution_description }}</p>
                </div>
                @if($session->report->parts_replaced)
                    <div class="border-t border-slate-800 pt-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Peças Substituídas</p>
                        <p class="text-sm text-slate-200 leading-relaxed whitespace-pre-line">{{ $session->report->parts_replaced }}</p>
                    </div>
                @endif
                @if($session->report->observations)
                    <div class="border-t border-slate-800 pt-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-1">Observações</p>
                        <p class="text-sm text-slate-200 leading-relaxed whitespace-pre-line">{{ $session->report->observations }}</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-4 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
            </svg>
            <p class="text-sm text-yellow-300">Relatório ainda não foi preenchido.</p>
        </div>
    @endif

</div>
