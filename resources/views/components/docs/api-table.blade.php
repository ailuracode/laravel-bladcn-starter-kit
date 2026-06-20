@props(['props' => []])

@if (count($props))
    <div class="overflow-hidden rounded-xl border">
        <table class="w-full caption-bottom text-sm">
            <thead class="border-b bg-muted/50">
                <tr class="border-b transition-colors">
                    <th class="h-10 w-[140px] px-4 text-left align-middle font-medium">{{ __('Prop') }}</th>
                    <th class="h-10 w-[120px] px-4 text-left align-middle font-medium">{{ __('Type') }}</th>
                    <th class="h-10 px-4 text-left align-middle font-medium">{{ __('Default') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($props as $prop)
                    <tr class="border-b transition-colors hover:bg-muted/50">
                        <td class="p-4 align-middle">
                            <code class="rounded bg-muted px-1.5 py-0.5 text-xs">{{ $prop['name'] }}</code>
                        </td>
                        <td class="p-4 align-middle text-muted-foreground">{{ $prop['type'] }}</td>
                        <td class="p-4 align-middle">
                            <code class="text-xs text-muted-foreground">{{ $prop['default'] }}</code>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <x-ui.typography.muted>{{ __('No documented props for this component.') }}</x-ui.typography.muted>
@endif
