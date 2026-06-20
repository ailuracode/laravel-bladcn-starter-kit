@props([
    'label',
    'name',
    'type' => 'text',
])

<x-ui.field>
    <x-ui.field.label :for="$name">{{ $label }}</x-ui.field.label>
    <x-ui.field.content>
        <x-ui.input :id="$name" :name="$name" :type="$type" {{ $attributes }} />
    </x-ui.field.content>
    @error($name)
        <x-ui.field.error>{{ $message }}</x-ui.field.error>
    @enderror
</x-ui.field>
