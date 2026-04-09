<div class="space-y-6 py-2">

    {{-- Resumo do atendimento --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 space-y-3">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
            <span class="text-xs font-semibold uppercase tracking-widest text-slate-400">Atendimento Concluído</span>
        </div>

        <h2 class="text-lg font-bold text-white">{{ $session->machine_name }}</h2>
        @if($session->machine_id)
            <span class="text-xs text-cyan-500 font-mono bg-cyan-500/10 px-2 py-0.5 rounded-full">{{ $session->machine_id }}</span>
        @endif

        <div class="grid grid-cols-2 gap-3 mt-2">
            <div class="bg-slate-800 rounded-xl p-3">
                <p class="text-xs text-slate-500 mb-1">Duração</p>
                <p class="text-xl font-bold text-orange-400 font-mono">{{ $session->duration_formatted }}</p>
            </div>
            <div class="bg-slate-800 rounded-xl p-3">
                <p class="text-xs text-slate-500 mb-1">Início</p>
                <p class="text-sm font-semibold text-slate-200">{{ $session->started_at->format('H:i') }}</p>
                <p class="text-xs text-slate-400">{{ $session->started_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Formulário do relatório --}}
    <div class="space-y-4">
        <h3 class="text-base font-bold text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Relatório de Atendimento
        </h3>

        {{-- Problema --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block">
                Problema Encontrado <span class="text-orange-500">*</span>
            </label>
            <textarea
                wire:model="problemDescription"
                rows="3"
                placeholder="Descreva o problema identificado na máquina..."
                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition resize-none"
            ></textarea>
            @error('problemDescription')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Solução --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block">
                Solução Aplicada <span class="text-orange-500">*</span>
            </label>
            <textarea
                wire:model="solutionDescription"
                rows="3"
                placeholder="Descreva o que foi feito para resolver o problema..."
                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition resize-none"
            ></textarea>
            @error('solutionDescription')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Peças --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block">
                Peças Substituídas
                <span class="text-slate-600 normal-case tracking-normal font-normal">(opcional)</span>
            </label>
            <textarea
                wire:model="partsReplaced"
                rows="2"
                placeholder="Ex: Correia V, rolamento 6205..."
                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition resize-none"
            ></textarea>
        </div>

        {{-- Observações --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block">
                Observações
                <span class="text-slate-600 normal-case tracking-normal font-normal">(opcional)</span>
            </label>
            <textarea
                wire:model="observations"
                rows="2"
                placeholder="Alguma observação adicional..."
                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition resize-none"
            ></textarea>
        </div>

        {{-- Botão Salvar --}}
        <button
            wire:click="save"
            wire:loading.attr="disabled"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-lg py-4 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-3"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span wire:loading.remove wire:target="save">Salvar Relatório</span>
            <span wire:loading wire:target="save">Salvando...</span>
        </button>
    </div>

</div>
