@php
    $title = 'Entrar';
@endphp

<x-layouts.auth-manut :title="$title">

    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold text-white">Entrar na conta</h1>
        <p class="text-sm text-slate-400 mt-1">Use seu e-mail e senha para acessar</p>
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

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

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
                autofocus
                autocomplete="email"
                placeholder="seu@email.com"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('email') border-red-500/60 @enderror"
            >
        </div>

        {{-- Senha --}}
        <div>
            <div class="flex items-center justify-between mb-1">
                <label class="text-xs font-semibold uppercase tracking-widest text-slate-400" for="password">
                    Senha
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-orange-400 hover:text-orange-300 transition-colors">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('password') border-red-500/60 @enderror"
            >
        </div>

        {{-- Lembrar-me --}}
        <label class="flex items-center gap-3 cursor-pointer group">
            <input
                type="checkbox"
                name="remember"
                {{ old('remember') ? 'checked' : '' }}
                class="w-4 h-4 rounded bg-slate-800 border border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-900"
            >
            <span class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Lembrar meu acesso</span>
        </label>

        {{-- Botão Entrar --}}
        <button
            type="submit"
            id="login-button"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-base py-3.5 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-2 mt-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Entrar
        </button>
    </form>

    @if (Route::has('register'))
        <p class="mt-5 text-center text-sm text-slate-500">
            Não tem conta?
            <a href="{{ route('register') }}" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">
                Criar conta
            </a>
        </p>
    @endif

</x-layouts.auth-manut>
