<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use App\Models\Property;
use Livewire\Attributes\On;

class Row extends Component
{
    public Property $property;

    #[On('property-updated.{property.id}')]
    public function render()
    {
        return view('livewire.properties.row');
    }
}
