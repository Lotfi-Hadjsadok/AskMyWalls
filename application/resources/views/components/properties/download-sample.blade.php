<flux:dropdown>
    <flux:button icon="folder-arrow-down">
        Download Sample
    </flux:button>
    <flux:navmenu>
        <flux:navmenu.item wire:click="downloadSample('csv')">CSV</flux:navmenu.item>
        <flux:navmenu.item wire:click="downloadSample('xlsx')">XLSX</flux:navmenu.item>
    </flux:navmenu>
</flux:dropdown>