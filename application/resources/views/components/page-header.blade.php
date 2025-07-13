@props(['title', 'description'])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between py-4']) }}>
    <div>
        <flux:heading>{{ $title }}</flux:heading>
        @if ($description ?? null)
        <flux:text class="mt-1">{{ $description }}</flux:text>
        @endif
    </div>

    @if (isset($actions))
    <div class="flex-shrink-0 flex gap-2">
        {{ $actions }}
    </div>
    @endif
</div>