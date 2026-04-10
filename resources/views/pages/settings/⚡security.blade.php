<?php

use App\Concerns\PasswordValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Segurança'), Layout('layouts.app-manut')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password'         => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(variant: 'success', text: 'Senha atualizada com sucesso.');
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

    <h2 class="text-base font-bold text-white mb-1">Alterar senha</h2>
    <p class="text-sm text-slate-400 mb-5">Use uma senha longa e aleatória para manter sua conta segura</p>

    <form wire:submit="updatePassword" class="space-y-4">

        {{-- Senha atual --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="current-password-field">
                Senha atual
            </label>
            <input
                id="current-password-field"
                wire:model="current_password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('current_password') border-red-500/60 @enderror"
            >
            @error('current_password')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nova senha --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="new-password-field">
                Nova senha
            </label>
            <input
                id="new-password-field"
                wire:model="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition
                       @error('password') border-red-500/60 @enderror"
            >
            @error('password')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmar nova senha --}}
        <div>
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1 block" for="confirm-password-field">
                Confirmar nova senha
            </label>
            <input
                id="confirm-password-field"
                wire:model="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600
                       focus:outline-none focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition"
            >
        </div>

        {{-- Botão Salvar --}}
        <button
            type="submit"
            id="update-password-button"
            class="w-full bg-orange-500 hover:bg-orange-400 active:scale-95 text-white font-bold text-base py-3.5 rounded-2xl
                   shadow-lg shadow-orange-500/30 transition-all duration-150 flex items-center justify-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span wire:loading.remove wire:target="updatePassword">Atualizar senha</span>
            <span wire:loading wire:target="updatePassword" class="flex items-center gap-2">
                <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                Salvando...
            </span>
        </button>
    </form>
</div>
