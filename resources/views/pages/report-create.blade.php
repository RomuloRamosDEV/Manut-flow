@extends('layouts.app-manut')

@section('title', 'Relatório de Atendimento')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-white">Relatório</h1>
        <p class="text-sm text-slate-400 mt-0.5">Preencha os detalhes do atendimento realizado</p>
    </div>

    @livewire('service-report.create', ['sessionId' => $sessionId])
@endsection
