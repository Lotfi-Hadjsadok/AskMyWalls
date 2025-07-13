<?php

namespace App\Livewire\Properties;

use Flux\Flux;
use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Train extends Component
{
    public function train()
    {
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to train embeddings.');
            return;
        }

        $userId = auth()->id();
        $properties = Property::where('user_id', $userId)
            ->whereNull('embedding')
            ->get();


        if ($properties->isEmpty()) {
            session()->flash('info', 'No properties without embeddings found.');
            return;
        }

        $payload = $properties->mapWithKeys(function ($property) {
            return [
                $property->id =>
                "title : $property->title
                description : $property->description
                address : $property->address
                city : $property->city
                state : $property->state
                country : $property->country
                zip_code : $property->zip_code
                type : {$property->type->label()}
                status : {$property->status->label()}
                availability : {$property->availability->label()}
                features : " . implode(', ', $property->features ?? [])
            ];
        });

        try {
            $response = Http::post(AI_SERVER_URL . '/api/embed', [
                'properties' => $payload,
                'userId' => $userId,
            ]);

            if ($response->successful()) {
                foreach ($response->json()['data'] as $data) {
                    $propertyId = $data['id'];
                    $embedding = $data['embedding'];
                    $property = Property::find($propertyId);
                    $property->embedding = $embedding;
                    $property->save();
                    $this->dispatch('property-updated.' . $propertyId);
                }
                Flux::toast(
                    heading: 'Success',
                    text: 'Training completed successfully.',
                    variant: 'success',
                );
            } else {
                session()->flash('error', 'Failed to send training request: ' . $response->body());
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            session()->flash('error', 'Error sending training request: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.properties.train');
    }
}
