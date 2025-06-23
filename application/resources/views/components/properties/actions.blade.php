@props(['property'])

<flux:dropdown>
    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
    <flux:menu>
        <flux:menu.item wire:click="$dispatch('view-property', { propertyId: {{ $property->id }} })" icon="eye">View
        </flux:menu.item>
        <flux:menu.item wire:click="$dispatch('edit-property', { propertyId: {{ $property->id }} })" icon="pencil">Edit
        </flux:menu.item>
        <flux:menu.item
            @click="if(confirm('Are you sure you want to delete this property?')) { $wire.delete({{ $property->id }}); }"
            icon="trash">Delete</flux:menu.item>
    </flux:menu>
</flux:dropdown>