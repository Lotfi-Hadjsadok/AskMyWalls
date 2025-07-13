<flux:modal name="import-properties" title="Import Properties">
    <div class="space-y-4">
        <p class="text-sm text-gray-500">
            Upload a CSV or XLSX file to import your properties.
        </p>

        <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <flux:input type="file" wire:model="upload" />

            <div x-show="uploading" class="mt-2">
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-primary-500 rounded-full" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        </div>

        @error('upload') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
    </div>
    <div class="flex justify-end gap-2">
        <flux:spacer />
        <flux:button @click="open = false" variant="ghost">Cancel</flux:button>
        <flux:button wire:click="import" @click="open = false" variant="primary">Import</flux:button>
    </div>
</flux:modal>