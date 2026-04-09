@extends('layouts.app-manut')

@section('title', 'Detalhe do Atendimento')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-white">Detalhe</h1>
        <p class="text-sm text-slate-400 mt-0.5">Informações completas do atendimento</p>
    </div>

    @livewire('service-detail', ['sessionId' => $sessionId])
@endsection
