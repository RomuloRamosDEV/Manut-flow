<?php

namespace App\Livewire\ServiceReport;

use App\Models\ServiceSession;
use Livewire\Component;

class Create extends Component
{
    public ServiceSession $session;
    public string $problemDescription = '';
    public string $solutionDescription = '';
    public string $partsReplaced = '';
    public string $observations = '';

    public function mount(int $sessionId): void
    {
        $this->session = ServiceSession::with('report', 'user')->findOrFail($sessionId);

        // Não permite acessar se ainda está rodando ou já tem relatório
        abort_if($this->session->status !== 'completed', 403, 'Atendimento ainda em andamento.');
        abort_if($this->session->report !== null, 403, 'Relatório já preenchido.');
        abort_if($this->session->user_id !== auth()->id(), 403);
    }

    public function save(): void
    {
        $this->validate([
            'problemDescription' => 'required|string|min:5',
            'solutionDescription' => 'required|string|min:5',
            'partsReplaced' => 'nullable|string',
            'observations' => 'nullable|string',
        ], [
            'problemDescription.required' => 'Descreva o problema encontrado.',
            'solutionDescription.required' => 'Descreva a solução aplicada.',
        ]);

        $this->session->report()->create([
            'problem_description' => $this->problemDescription,
            'solution_description' => $this->solutionDescription,
            'parts_replaced' => $this->partsReplaced ?: null,
            'observations' => $this->observations ?: null,
        ]);

        $this->redirect(route('history'));
    }

    public function render()
    {
        return view('livewire.service-report.create');
    }
}
