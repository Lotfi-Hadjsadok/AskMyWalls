<form wire:submit="save">
    <flux:modal name="upsert-property" class="md:w-4xl">
        <div class="space-y-6 p-4">
            <div>
                <flux:heading size="lg">{{ $isEditing ? 'Edit' : 'Add' }} Property</flux:heading>
                <flux:text class="mt-2">{{ $isEditing ? 'Update the details for the property.' : 'Enter the details for
                    the new property.' }}</flux:text>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:field class="md:col-span-1">
                    <flux:label for="title">Title</flux:label>
                    <flux:input wire:model="form.title" id="title" />
                    <flux:error name="form.title" />
                </flux:field>

                <flux:field class="md:col-span-2">
                    <flux:label for="description">Description</flux:label>
                    <flux:textarea wire:model="form.description" id="description" />
                    <flux:error name="form.description" />
                </flux:field>

                <flux:field>
                    <flux:label for="address">Address</flux:label>
                    <flux:input wire:model="form.address" id="address" />
                    <flux:error name="form.address" />
                </flux:field>
                <flux:field>
                    <flux:label for="city">City</flux:label>
                    <flux:input wire:model="form.city" id="city" />
                    <flux:error name="form.city" />
                </flux:field>
                <flux:field>
                    <flux:label for="state">State</flux:label>
                    <flux:input wire:model="form.state" id="state" />
                    <flux:error name="form.state" />
                </flux:field>
                <flux:field>
                    <flux:label for="zip_code">Zip Code</flux:label>
                    <flux:input wire:model="form.zip_code" id="zip_code" />
                    <flux:error name="form.zip_code" />
                </flux:field>
                <flux:field>
                    <flux:label for="country">Country</flux:label>
                    <flux:input wire:model="form.country" id="country" />
                    <flux:error name="form.country" />
                </flux:field>
                <flux:field>
                    <flux:label for="price">Price</flux:label>
                    <flux:input wire:model="form.price" id="price" type="number" step="0.01" />
                    <flux:error name="form.price" />
                </flux:field>
                <flux:field>
                    <flux:label for="bedrooms">Bedrooms</flux:label>
                    <flux:input wire:model="form.bedrooms" id="bedrooms" type="number" />
                    <flux:error name="form.bedrooms" />
                </flux:field>
                <flux:field>
                    <flux:label for="bathrooms">Bathrooms</flux:label>
                    <flux:input wire:model="form.bathrooms" id="bathrooms" type="number" />
                    <flux:error name="form.bathrooms" />
                </flux:field>
                <flux:field>
                    <flux:label for="area">Area (sqft)</flux:label>
                    <flux:input wire:model="form.area" id="area" type="number" />
                    <flux:error name="form.area" />
                </flux:field>
                <flux:field>
                    <flux:label for="year_built">Year Built</flux:label>
                    <flux:input wire:model="form.year_built" id="year_built" type="number" />
                    <flux:error name="form.year_built" />
                </flux:field>
                <flux:field>
                    <flux:label for="type">Type</flux:label>
                    <flux:select wire:model="form.type" id="type">
                        <option value="" disabled selected>Select type</option>
                        @foreach ($types as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.type" />
                </flux:field>
                <flux:field>
                    <flux:label for="status">Status</flux:label>
                    <flux:select wire:model="form.status" id="status">
                        <option value="" disabled selected>Select status</option>
                        @foreach ($statuses as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.status" />
                </flux:field>
                <flux:field>
                    <flux:label for="availability">Availability</flux:label>
                    <flux:select wire:model="form.availability" id="availability">
                        <option value="" disabled selected>Select availability</option>
                        @foreach ($availabilities as $availability)
                        <option value="{{ $availability->value }}">{{ $availability->label() }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.availability" />
                </flux:field>
                <flux:field class="md:col-span-3">
                    <flux:label for="features">Features (comma-separated)</flux:label>
                    <flux:input wire:model="form.features" id="features" placeholder="Pool, Garden, Garage" />
                    <flux:error name="form.features" />
                </flux:field>
                <flux:field class="md:col-span-3">
                    <flux:label for="images">Images (comma-separated URLs)</flux:label>
                    <flux:input wire:model="form.images" id="images" />
                    <flux:error name="form.images" />
                </flux:field>
                <flux:field class="md:col-span-3">
                    <flux:label for="videos">Videos (comma-separated URLs)</flux:label>
                    <flux:input wire:model="form.videos" id="videos" />
                    <flux:error name="form.videos" />
                </flux:field>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="ghost"
                    x-on:click="$dispatch('close-modal', { name: 'upsert-property' })">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="ms-2">{{ $isEditing ? 'Save Changes' : 'Save' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</form>