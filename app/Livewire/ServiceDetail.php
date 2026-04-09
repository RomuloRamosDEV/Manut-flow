<?php

namespace App\Livewire;

use App\Models\ServiceSession;
use Livewire\Component;

class ServiceDetail extends Component
{
    public ServiceSession $session;

    public function mount(int $sessionId): void
    {
        $this->session = ServiceSession::with('report', 'user')->findOrFail($sessionId);
        abort_if($this->session->user_id !== auth()->id(), 403);
    }

    public function render()
    {
        return view('livewire.service-detail');
    }
}
