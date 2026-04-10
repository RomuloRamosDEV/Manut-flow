@php
    $title = 'Criar conta';
@endphp

<x-layouts.auth-manut :title="$title">

    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold text-white">Criar conta</h1>
        <p class="text-sm text-slate-400 mt-1">Preencha seus dados para se cadastrar</p>
    </div>

    {{-- Erros globais --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        {{-- Nome --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="name">
                Nome completo
            </label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Seu nome"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('name') border-red-500/60 @enderror"
            >
        </div>

        {{-- Email --}}
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
                autocomplete="email"
                placeholder="seu@email.com"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('email') border-red-500/60 @enderror"
            >
        </div>

        {{-- Senha --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="password">
                Senha
            </label>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('password') border-red-500/60 @enderror"
            >
        </div>

        {{-- Confirmar senha --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="password_confirmation">
                Confirmar senha
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition"
            >
        </div>

        {{-- Botão Criar --}}
        <button
            type="submit"
            id="register-user-button"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-base py-3.5 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-2 mt-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Criar conta
        </button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-500">
        Já tem conta?
        <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">
            Entrar
        </a>
    </p>

</x-layouts.auth-manut>
