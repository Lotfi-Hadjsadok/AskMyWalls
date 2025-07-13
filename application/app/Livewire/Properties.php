<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Imports\PropertiesImport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Exports\PropertiesSampleExport;
use Illuminate\Support\Facades\Response;
use App\Models\PropertyType;
use App\Models\PropertyStatus;
use App\Models\PropertyAvailability;

class Properties extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $upload;
    public array $propertyIdsOnPage = [];

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public array $propertyTypeOptions = [];
    public array $propertyStatusOptions = [];
    public array $propertyAvailabilityOptions = [];

    #[On('property-created')]
    #[On('refresh-properties')]
    public function render(): View
    {
        $properties = auth()->user()->properties()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
        $this->propertyIdsOnPage = $properties->pluck('id')->map(fn($id) => (string) $id)->toArray();

        $this->propertyTypeOptions = collect(PropertyType::cases())->map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ])->toArray();
        $this->propertyStatusOptions = collect(PropertyStatus::cases())->map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ])->toArray();
        $this->propertyAvailabilityOptions = collect(PropertyAvailability::cases())->map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ])->toArray();

        return view('livewire.properties.index', [
            'properties' => $properties,
        ]);
    }

    public function import()
    {
        $this->validate([
            'upload' => 'required|mimes:csv,xlsx'
        ]);

        Excel::import(new PropertiesImport(), $this->upload);

        $this->upload = null;
    }

    public function downloadSample(string $format = 'csv')
    {
        if ($format === 'xlsx') {
            return Excel::download(new PropertiesSampleExport(), 'sample-properties.xlsx');
        }

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=sample-properties.csv',
        ];

        $columns = Schema::getColumnListing('properties');
        $columns = array_diff($columns, ['id', 'user_id', 'created_at', 'updated_at', 'embedding']);

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

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


    public function selectAll()
    {
        $this->propertyIdsOnPage = Property::pluck('id')->map(fn($id) => (string) $id)->toArray();
    }
}
