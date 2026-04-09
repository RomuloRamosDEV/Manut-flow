@extends('layouts.app-manut')

@section('title', 'Atendimento')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-white">Cronômetro</h1>
        <p class="text-sm text-slate-400 mt-0.5">Registre o tempo do seu atendimento</p>
    </div>

    @livewire('timer')
@endsection
