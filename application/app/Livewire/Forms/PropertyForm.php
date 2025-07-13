<?php

namespace App\Livewire\Forms;

use App\Models\Property;
use Livewire\Form;
use Illuminate\Support\Facades\Auth;

class PropertyForm extends Form
{
    public ?Property $property;

    public string $title = '';
    public string $description = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $zip_code = '';
    public string $country = '';
    public float $price = 0;
    public int $bedrooms = 0;
    public int $bathrooms = 0;
    public int $area = 0;
    public string $type = '';
    public string $status = '';
    public string $availability = '';
    public ?int $year_built = null;
    public string $features = '';
    public string $images = '';
    public string $videos = '';

    public function setProperty(Property $property)
    {
        $this->property = $property;
        $this->title = $property->title;
        $this->description = $property->description;
        $this->address = $property->address;
        $this->city = $property->city;
        $this->state = $property->state;
        $this->zip_code = $property->zip_code;
        $this->country = $property->country;
        $this->price = $property->price;
        $this->bedrooms = $property->bedrooms;
        $this->bathrooms = $property->bathrooms;
        $this->area = $property->area;
        $this->type = is_object($property->type) ? $property->type->value : $property->type;
        $this->status = is_object($property->status) ? $property->status->value : $property->status;
        $this->availability = is_object($property->availability) ? $property->availability->value : $property->availability;
        $this->year_built = $property->year_built;
        $this->features = is_array($property->features) ? implode(', ', $property->features) : '';
        $this->images = is_array($property->images) ? implode(', ', $property->images) : '';
        $this->videos = is_array($property->videos) ? implode(', ', $property->videos) : '';
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|integer|min:0',
            'type' => 'required|string',
            'status' => 'required|string',
            'availability' => 'required|string',
            'year_built' => 'nullable|integer|min:1800',
            'features' => 'nullable|string',
            'images' => 'nullable|string',
            'videos' => 'nullable|string',
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        $validated['features'] = array_filter(array_map('trim', explode(',', $this->features)));
        $validated['images'] = array_filter(array_map('trim', explode(',', $this->images)));
        $validated['videos'] = array_filter(array_map('trim', explode(',', $this->videos)));

        Auth::user()->properties()->create($validated);
        $this->reset();
    }

    public function update()
    {
        $validated = $this->validate();
        $validated['features'] = array_filter(array_map('trim', explode(',', $this->features)));
        $validated['images'] = array_filter(array_map('trim', explode(',', $this->images)));
        $validated['videos'] = array_filter(array_map('trim', explode(',', $this->videos)));
        $this->property->embedding = null;
        $this->property->update($validated);
        $this->reset();
    }
}
