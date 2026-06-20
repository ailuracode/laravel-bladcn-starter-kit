@props([
    'label',
    'name',
    'type' => 'text',
])

<x-ui.field>
    <x-ui.field.label>{{ $label }}</x-ui.field.label>
    <x-ui.field.content>
        <x-ui.input wire:model="{{ $name }}" :type="$type" {{ $attributes }} />
    </x-ui.field.content>
    @error($name)
        <x-ui.field.error>{{ $message }}</x-ui.field.error>
    @enderror
</x-ui.field>
