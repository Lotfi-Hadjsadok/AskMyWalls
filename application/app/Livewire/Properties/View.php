<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class View extends Component
{
    public ?Property $property = null;

    #[On('view-property')]
    public function viewProperty($propertyId)
    {
        $this->property = Property::findOrFail($propertyId);
        Flux::modal('view-property')->show();
    }

    public function render()
    {
        return view('livewire.properties.view');
    }
}
