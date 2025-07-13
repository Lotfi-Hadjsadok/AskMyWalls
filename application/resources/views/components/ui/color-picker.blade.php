@php
$modelName = $attributes->whereStartsWith('wire:model')->first();
$modelName = str_replace('wire:model', '', $modelName);
$modelName = trim($modelName, '="\'');
@endphp

<div class="relative border rounded-full w-10 h-10" :style="{ backgroundColor: color }"
    x-data="{ color: $wire.{{ $modelName }} }">
    <input type="color" x-model="color" {{ $attributes->merge(['class' => 'absolute! top-0! bottom-0! left-0! right-0!
    w-full! h-full! opacity-0! cursor-pointer!']) }}
    />
</div>