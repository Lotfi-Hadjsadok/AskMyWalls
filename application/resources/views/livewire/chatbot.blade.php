<flux:tab.group>
    <flux:tabs wire:model="tab">
        <flux:tab name="settings">Settings</flux:tab>
        <flux:tab name="embed">Embed on your website</flux:tab>
        <flux:tab name="logs">Logs</flux:tab>
    </flux:tabs>

    <flux:tab.panel name="settings">
        <form wire:submit.prevent="updateSettings" class="space-y-6 mt-4">
            <flux:input wire:model="headline" label="Headline" placeholder="Enter chatbot headline"
                description="This will be displayed at the top of your chatbot" />

            <flux:textarea wire:model="welcomeMessage" label="Welcome Message"
                placeholder="Enter welcome message for visitors"
                description="This message will greet your visitors when they open the chatbot" rows="3" />

            <flux:field variant="inline" class="w-fit">
                <flux:label>Include not available property</flux:label>
                <flux:switch wire:model.live="includeNotAvailableProperty" />
                <flux:error name="includeNotAvailableProperty" />
            </flux:field>

            <flux:field>
                <flux:label>Primary Color</flux:label>
                <flux:description>Choose the main color for your chatbot interface</flux:description>
                <x-ui.color-picker wire:model="primaryColor" />
            </flux:field>



            <flux:button type="submit" variant="primary">Save Settings</flux:button>
        </form>
    </flux:tab.panel>

    <flux:tab.panel name="embed">
        <div class="mt-4 space-y-4">
            <flux:field>
                <flux:label>Copy and paste this iframe into your website:</flux:label>
                <flux:input.group>
                    <flux:input readonly variant="filled" value='<iframe src="{{ url(' /chatbot/embed') }}" width="400"
                        height="600" style="border:0;"></iframe>'
                        id="embedCode"
                        copyable
                        />
                </flux:input.group>
            </flux:field>
        </div>
    </flux:tab.panel>

    <flux:tab.panel name="logs">
        <div class="mt-4">
            <flux:heading size="lg">Chatbot Sessions</flux:heading>
            <div class="mt-4 space-y-2">
                @forelse($logs as $log)
                <flux:card class="p-4">
                    {{ $log }}
                </flux:card>
                @empty
                <flux:card class="p-4 text-center">
                    <flux:text variant="muted">No logs available.</flux:text>
                </flux:card>
                @endforelse
            </div>
        </div>
    </flux:tab.panel>
</flux:tab.group>