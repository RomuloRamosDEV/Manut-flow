<div
    x-data="{
        elapsed: @entangle('elapsed').live,
        status: @entangle('status').live,
        ticker: null,
        init() {
            if (this.status === 'running') {
                this.startTicker();
            }
            this.$watch('status', val => {
                if (val === 'running') {
                    this.startTicker();
                } else {
                    this.stopTicker();
                }
            });
        },
        startTicker() {
            this.stopTicker();
            this.ticker = setInterval(() => { this.elapsed++ }, 1000);
        },
        stopTicker() {
            if (this.ticker) { clearInterval(this.ticker); this.ticker = null; }
        },
        format(s) {
            const h = Math.floor(s / 3600).toString().padStart(2, '0');
            const m = Math.floor((s % 3600) / 60).toString().padStart(2, '0');
            const sec = (s % 60).toString().padStart(2, '0');
            return `${h}:${m}:${sec}`;
        }
    }"
    class="flex flex-col items-center gap-6 py-6"
>

    {{-- ======================== --}}
    {{-- ESTADO: IDLE             --}}
    {{-- ======================== --}}
    <div x-show="status === 'idle'" x-transition class="w-full space-y-6">

        <!-- Ícone central -->
        <div class="flex flex-col items-center gap-3 pt-4">
            <div class="w-24 h-24 rounded-full border-2 border-slate-700 flex items-center justify-center bg-slate-900 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <p class="text-slate-400 text-sm">Pronto para iniciar atendimento</p>
        </div>

        <!-- Campos da máquina -->
        <div class="space-y-3">
            <div>
                <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block">
                    Máquina / Equipamento <span class="text-orange-500">*</span>
                </label>
                <input
                    wire:model.live="machineName"
                    type="text"
                    placeholder="Ex: Torno CNC - Linha 3"
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                           focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                >
                @error('machineName')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block">
                    Código / Patrimônio <span class="text-slate-600 font-normal normal-case tracking-normal">(opcional)</span>
                </label>
                <input
                    wire:model.live="machineId"
                    type="text"
                    placeholder="Ex: MQ-0042"
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                           focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition"
                >
            </div>
        </div>

        <!-- Botão Iniciar -->
        <button
            wire:click="start"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-60 cursor-not-allowed"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-lg py-4 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-3"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
            <span wire:loading.remove wire:target="start">Iniciar Atendimento</span>
            <span wire:loading wire:target="start" class="flex items-center gap-2">
                <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                Iniciando...
            </span>
        </button>
    </div>

    {{-- ======================== --}}
    {{-- ESTADO: RUNNING          --}}
    {{-- ======================== --}}
    <div x-show="status === 'running'" x-transition class="w-full flex flex-col items-center gap-8 pt-4">

        <!-- Info da máquina -->
        <div class="text-center">
            <p class="text-xs uppercase tracking-widest text-slate-500 font-semibold">Em atendimento</p>
            <h2 class="text-xl font-bold text-white mt-1">{{ $machineName }}</h2>
            @if($machineId)
                <span class="text-xs text-cyan-500 font-mono bg-cyan-500/10 px-2 py-0.5 rounded-full mt-1 inline-block">{{ $machineId }}</span>
            @endif
        </div>

        <!-- Display do cronômetro -->
        <div class="relative flex items-center justify-center" style="height: 224px; width: 224px;">
            <!-- Anel pulsante -->
            <div class="absolute inset-0 rounded-full border-2 border-orange-500/40 animate-ping-slow"></div>
            <div class="absolute rounded-full border border-orange-500/20" style="inset: 16px;"></div>
            <!-- Display circular -->
            <div class="absolute rounded-full bg-slate-900 border-2 border-orange-500/60 flex flex-col items-center justify-center shadow-2xl shadow-orange-500/20"
                 style="inset: 28px;">
                <span class="font-mono text-4xl font-bold text-white tracking-tighter"
                      x-text="format(elapsed)">00:00:00</span>
                <span class="text-xs text-orange-400 font-semibold mt-1 animate-pulse">● AO VIVO</span>
            </div>
        </div>

        <!-- Botão Concluído -->
        <button
            wire:click="finish"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-60 cursor-not-allowed"
            class="w-full bg-emerald-500 hover:bg-emerald-400 active:scale-95 text-white font-bold text-lg py-4 rounded-2xl
                   shadow-lg shadow-emerald-500/30 transition-all duration-150 flex items-center justify-center gap-3"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span wire:loading.remove wire:target="finish">Concluir Atendimento</span>
            <span wire:loading wire:target="finish" class="flex items-center gap-2">
                <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                Finalizando...
            </span>
        </button>

        <p class="text-xs text-slate-600 text-center">
            Pressione "Concluir" ao terminar o reparo para preencher o relatório
        </p>
    </div>

</div>

<style>
@keyframes ping-slow {
    0%, 100% { transform: scale(1); opacity: 0.4; }
    50% { transform: scale(1.08); opacity: 0.1; }
}
.animate-ping-slow { animation: ping-slow 2s ease-in-out infinite; }
</style>
