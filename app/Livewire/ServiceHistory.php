<?php

namespace App\Livewire;

use App\Models\ServiceSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceHistory extends Component
{
    use WithPagination;

    public string $search = '';
    public string $dateFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Auth::user()
            ->serviceSessions()
            ->with('report')
            ->where('status', 'completed')
            ->orderByDesc('finished_at');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('machine_name', 'like', '%'.$this->search.'%')
                    ->orWhere('machine_id', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->dateFilter) {
            $query->whereDate('started_at', $this->dateFilter);
        }

        return view('livewire.service-history', [
            'sessions' => $query->paginate(10),
        ]);
    }
}
