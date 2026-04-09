@extends('layouts.app-manut')

@section('title', 'Histórico de Atendimentos')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-white">Histórico</h1>
        <p class="text-sm text-slate-400 mt-0.5">Seus atendimentos registrados</p>
    </div>

    @livewire('service-history')
@endsection
