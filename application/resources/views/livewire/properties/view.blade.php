<flux:modal name="view-property" class="md:w-2xl">
    @if ($property)
    <div class="space-y-6 p-4">
        <div>
            <flux:heading size="lg">Property Details</flux:heading>
            <flux:text class="mt-2">All information for <b>{{ $property->title }}</b></flux:text>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><b>Title:</b> {{ $property->title }}</div>
            <div><b>Description:</b> {{ $property->description }}</div>
            <div><b>Address:</b> {{ $property->address }}</div>
            <div><b>City:</b> {{ $property->city }}</div>
            <div><b>State:</b> {{ $property->state }}</div>
            <div><b>Zip:</b> {{ $property->zip_code }}</div>
            <div><b>Country:</b> {{ $property->country }}</div>
            <div><b>Price:</b> ${{ number_format($property->price, 2) }}</div>
            <div><b>Bedrooms:</b> {{ $property->bedrooms }}</div>
            <div><b>Bathrooms:</b> {{ $property->bathrooms }}</div>
            <div><b>Area:</b> {{ $property->area }}</div>
            <div><b>Type:</b> {{ $property->type }}</div>
            <div><b>Status:</b> {{ $property->status }}</div>
            <div><b>Year Built:</b> {{ $property->year_built }}</div>
            <div><b>Features:</b> {{ is_array($property->features) ? implode(', ', $property->features) :
                $property->features }}</div>
            <div><b>User:</b> {{ $property->user?->name ?? 'N/A' }}</div>
        </div>
        <div>
            <b>Images:</b>
            <div class="flex gap-2 mt-1">
                @if(is_array($property->images))
                @foreach($property->images as $img)
                <img src="{{ $img }}" alt="Image" class="w-16 h-16 object-cover rounded" />
                @endforeach
                @else
                {{ $property->images }}
                @endif
            </div>
        </div>
        <div>
            <b>Videos:</b>
            <div class="flex flex-col gap-1 mt-1">
                @if(is_array($property->videos))
                @foreach($property->videos as $vid)
                <a href="{{ $vid }}" target="_blank" class="text-blue-600 underline">{{ $vid }}</a>
                @endforeach
                @else
                {{ $property->videos }}
                @endif
            </div>
        </div>
    </div>
    @endif
</flux:modal>