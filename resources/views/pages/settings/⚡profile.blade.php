<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Configurações'), Layout('layouts.app-manut')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';

    public function mount(): void
    {
        $this->name  = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: 'Perfil atualizado com sucesso.');
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('timer', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: 'Um novo link de verificação foi enviado para o seu e-mail.');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }
}; ?>

<div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">Configurações</h1>
    <p class="text-sm text-slate-400 mt-0.5">Gerencie seu perfil e senha</p>
</div>

{{-- Nav tabs --}}
<div class="flex gap-1 mb-6 bg-slate-900 p-1 rounded-xl border border-slate-800">
    <a
        href="{{ route('profile.edit') }}"
        class="flex-1 text-center text-sm font-semibold py-2 rounded-lg transition-all
               {{ request()->routeIs('profile.edit') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white' }}"
    >
        Perfil
    </a>
    <a
        href="{{ route('security.edit') }}"
        class="flex-1 text-center text-sm font-semibold py-2 rounded-lg transition-all
               {{ request()->routeIs('security.edit') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white' }}"
    >
        Segurança
    </a>
</div>

{{-- Card --}}
<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-xl">

    <h2 class="text-base font-bold text-white mb-1">Dados do perfil</h2>
    <p class="text-sm text-slate-400 mb-5">Atualize seu nome e endereço de e-mail</p>

    <form wire:submit="updateProfileInformation" class="space-y-4">

        {{-- Nome --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="name-field">
                Nome
            </label>
            <input
                id="name-field"
                wire:model="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Seu nome"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('name') border-red-500/60 @enderror"
            >
            @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="email-field">
                E-mail
            </label>
            <input
                id="email-field"
                wire:model="email"
                type="email"
                required
                autocomplete="email"
                placeholder="seu@email.com"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('email') border-red-500/60 @enderror"
            >
            @error('email')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror

            @if ($this->hasUnverifiedEmail)
                <div class="mt-2 p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs">
                    Seu e-mail não foi verificado.
                    <button type="button" wire:click.prevent="resendVerificationNotification" class="underline hover:text-amber-300 transition-colors">
                        Clique aqui para reenviar o link.
                    </button>
                </div>
            @endif
        </div>

        {{-- Botão Salvar --}}
        <button
            type="submit"
            id="update-profile-button"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-base py-3.5 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span wire:loading.remove wire:target="updateProfileInformation">Salvar alterações</span>
            <span wire:loading wire:target="updateProfileInformation" class="flex items-center gap-2">
                <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                Salvando...
            </span>
        </button>
    </form>
</div>
