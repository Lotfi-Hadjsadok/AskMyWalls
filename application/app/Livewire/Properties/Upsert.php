<?php

namespace App\Livewire\Properties;

use App\Livewire\Forms\PropertyForm;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyStatus;
use App\Models\PropertyAvailability;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class Upsert extends Component
{
    public PropertyForm $form;
    public bool $isEditing = false;

    #[On('create-property')]
    public function createProperty()
    {
        $this->isEditing = false;
        $this->form->reset();
        Flux::modal('upsert-property')->show();
    }

    #[On('edit-property')]
    public function editProperty($propertyId)
    {
        $this->isEditing = true;
        $property = Property::findOrFail($propertyId);
        $this->form->setProperty($property);
        Flux::modal('upsert-property')->show();
    }

    public function save()
    {
        if ($this->isEditing) {
            $property = $this->form->property;
            $this->form->update();
            $this->dispatch('property-updated.' . $property->id);
        } else {
            $this->form->store();
            $this->dispatch('property-created');
        }
        Flux::modals()->close();
    }

    public function render()
    {
        return view('livewire.properties.upsert', [
            'types' => PropertyType::cases(),
            'statuses' => PropertyStatus::cases(),
            'availabilities' => PropertyAvailability::cases(),
        ]);
    }
}
