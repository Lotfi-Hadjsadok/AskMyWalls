<div x-data="{ selected: [] }">
    <x-page-header title="Properties" description="Manage your properties here.">
        <x-slot:actions>
            <flux:button x-cloak x-show=" selected.length > 0" @click="if(confirm('Are you sure you want to delete the selected properties?')) {
                $wire.deleteSelected(selected); selected = [] }" icon="trash" variant="danger">
                Delete Selected (<span x-text="selected.length"></span>)
            </flux:button>
            <x-properties.download-sample />
            <livewire:properties.train />
            <flux:dropdown>
                <flux:button icon="plus" variant="primary">
                    Add Property
                </flux:button>
                <flux:navmenu>
                    <flux:navmenu.item @click="$flux.modal('import-properties').show()">Import</flux:navmenu.item>
                    <flux:navmenu.item wire:click="$dispatch('create-property')">Manual</flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>
        </x-slot:actions>
    </x-page-header>
    <div class="overflow-x-auto">

        <flux:table :paginate="$properties">
            <flux:table.columns>
                <flux:table.column>
                    <flux:checkbox class="" @change="selected = $event.target.checked ? $wire.propertyIdsOnPage : []"
                        x-bind:checked="selected.length === $wire.propertyIdsOnPage.length && $wire.propertyIdsOnPage.length > 0" />
                </flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Address</flux:table.column>
                <flux:table.column>Price</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Type</flux:table.column>
                <flux:table.column>Availability</flux:table.column>
                <flux:table.column>Trained</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($properties as $property)
                <livewire:properties.row :property="$property" :key="$property->id" />
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
    <livewire:properties.upsert />
    <livewire:properties.view />
    <x-properties.import-modal />
</div>