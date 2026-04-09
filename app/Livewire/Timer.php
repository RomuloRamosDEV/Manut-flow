<?php

namespace App\Livewire;

use App\Models\ServiceSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Timer extends Component
{
    public ?int $sessionId = null;
    public string $status = 'idle'; // idle | running | completed
    public int $elapsed = 0;
    public string $machineId = '';
    public string $machineName = '';

    public function mount(): void
    {
        // Verifica se há uma sessão ativa para o usuário logado
        $running = Auth::user()
            ->serviceSessions()
            ->where('status', 'running')
            ->latest()
            ->first();

        if ($running) {
            $this->sessionId = $running->id;
            $this->status = 'running';
            $this->machineId = $running->machine_id ?? '';
            $this->machineName = $running->machine_name ?? '';
            $this->elapsed = now()->diffInSeconds($running->started_at);
        }
    }

    public function start(): void
    {
        if ($this->status !== 'idle') {
            return;
        }

        $this->validate([
            'machineName' => 'required|string|max:255',
        ], [
            'machineName.required' => 'Informe o nome ou código da máquina.',
        ]);

        $session = Auth::user()->serviceSessions()->create([
            'machine_id' => $this->machineId ?: null,
            'machine_name' => $this->machineName,
            'started_at' => now(),
            'status' => 'running',
        ]);

        $this->sessionId = $session->id;
        $this->status = 'running';
        $this->elapsed = 0;
    }

    public function finish(): void
    {
        if ($this->status !== 'running' || ! $this->sessionId) {
            return;
        }

        $session = ServiceSession::findOrFail($this->sessionId);
        $duration = now()->diffInSeconds($session->started_at);

        $session->update([
            'finished_at' => now(),
            'duration_seconds' => $duration,
            'status' => 'completed',
        ]);

        $this->status = 'completed';

        $this->redirect(route('report.create', $session->id));
    }

    public function render()
    {
        return view('livewire.timer');
    }
}
