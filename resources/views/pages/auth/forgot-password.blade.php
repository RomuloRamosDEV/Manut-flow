@php
    $title = 'Recuperar senha';
@endphp

<x-layouts.auth-manut :title="$title">

    <div class="mb-6 text-center">
        <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-white">Recuperar senha</h1>
        <p class="text-sm text-slate-400 mt-1">Informe seu e-mail para receber o link</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    {{-- Erros globais --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="email">
                E-mail
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                placeholder="seu@email.com"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('email') border-red-500/60 @enderror"
            >
        </div>

        <button
            type="submit"
            id="email-password-reset-link-button"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-base py-3.5 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Enviar link de recuperação
        </button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-500">
        Lembrou a senha?
        <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">
            Voltar ao login
        </a>
    </p>

</x-layouts.auth-manut>
