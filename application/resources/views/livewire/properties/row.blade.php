<flux:table.row>
    <flux:table.cell>
        <flux:checkbox x-model="selected" value="{{ $property->id }}" />
    </flux:table.cell>
    <flux:table.cell class="truncate max-w-[120px]" title="{{ $property->title }}">
        {{ $property->title }}
    </flux:table.cell>
    <flux:table.cell class="truncate max-w-[120px]" title="{{ $property->address }}">
        {{ $property->address }}
    </flux:table.cell>
    <flux:table.cell variant="strong">
        ${{ number_format($property->price, 2) }}
    </flux:table.cell>
    <flux:table.cell>
        <flux:badge size="sm" color="{{ $property->status->color() }}">{{ $property->status->label() }}</flux:badge>
    </flux:table.cell>
    <flux:table.cell>
        <flux:badge size="sm" color="{{ $property->type->color() }}">{{ $property->type->label() }}</flux:badge>
    </flux:table.cell>
    <flux:table.cell>
        <flux:badge size="sm" color="{{ $property->availability->color() }}">{{ $property->availability->label() }}
        </flux:badge>
    </flux:table.cell>
    <flux:table.cell>
        @if ($property->embedding)
            <flux:icon name="check-badge" class="text-green-500" />
        @else
            <flux:icon name="x-circle" class="text-red-500" />
        @endif
    </flux:table.cell>
    <flux:table.cell>
        <x-properties.actions :property="$property" />
    </flux:table.cell>
</flux:table.row>