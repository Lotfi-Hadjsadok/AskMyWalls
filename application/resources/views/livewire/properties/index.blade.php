@php
$propertyIds = $this->properties->pluck('id')->map(fn ($id) => (string) $id)->toArray();
@endphp

<div x-data="{ selected: [], allPropertyIds: {{ json_encode($propertyIds) }} }"
    x-on:property-created="$dispatch('close-modal', { name: 'upsert-property' }); $wire.call('$refresh')"
    x-on:property-updated="$dispatch('close-modal', { name: 'upsert-property' }); $wire.call('$refresh')">
    <x-page-header title="Properties" description="Manage your properties here.">
        <x-slot:actions>
            <flux:button x-cloak x-show=" selected.length > 0" @click="if(confirm('Are you sure you want to delete the selected properties?')) {
                $wire.deleteSelected(selected); selected = [] }" icon="trash" variant="danger">
                Delete Selected (<span x-text="selected.length"></span>)
            </flux:button>
            <flux:button wire:click="$dispatch('create-property')" icon="plus" variant="primary">Add Property
            </flux:button>
        </x-slot:actions>
    </x-page-header>
    <div class="overflow-x-auto">
        <flux:table :paginate="$this->properties">
            <flux:table.columns>
                <flux:table.column>
                    <flux:checkbox x-on:change="selected = $event.target.checked ? allPropertyIds : []"
                        x-bind:checked="selected.length === allPropertyIds.length && allPropertyIds.length > 0" />
                </flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Address</flux:table.column>
                <flux:table.column>Price</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->properties as $property)
                <flux:table.row :key="$property->id" wire:key="property-{{ $property->id }}">
                    <flux:table.cell>
                        <flux:checkbox x-model="selected" value="{{ $property->id }}" />
                    </flux:table.cell>
                    <flux:table.cell class="truncate max-w-[120px]" title="{{ $property->title }}">{{ $property->title
                        }}</flux:table.cell>
                    <flux:table.cell class="truncate max-w-[120px]" title="{{ $property->address }}">{{
                        $property->address }}</flux:table.cell>
                    <flux:table.cell variant="strong">${{ number_format($property->price, 2) }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" color="primary">{{ $property->status }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <x-properties.actions :property="$property" />
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
    <livewire:properties.upsert />
    <livewire:properties.view />
</div>