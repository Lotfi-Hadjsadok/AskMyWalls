<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Properties extends Component
{
    use WithPagination;

    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    public function delete(int $propertyId): void
    {
        Property::findOrFail($propertyId)->delete();
    }

    public function deleteSelected(array $ids): void
    {
        Property::whereIn('id', $ids)->delete();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function properties()
    {
        return Property::query()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.properties.index');
    }
}
