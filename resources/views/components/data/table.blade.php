@props([
    'headers' => [],  // ['No', 'Nama', 'Status'] atau [['label'=>'Nama','key'=>'nama','sortable'=>true]]
    'rows'    => [],  // array of arrays atau collections
    'striped' => false,
])

<div {{ $attributes->merge(['class' => 'overflow-x-auto rounded-lg border border-border-custom bg-surface']) }}>
    <table class="min-w-full divide-y divide-border-custom text-sm">
        <thead class="bg-background">
            <tr>
                @foreach($headers as $header)
                    @php
                        $label = is_array($header) ? $header['label'] : $header;
                    @endphp
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider whitespace-nowrap">
                        {{ $label }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-surface divide-y divide-border-custom">
            @forelse($rows as $i => $row)
                <tr class="{{ $striped && $i % 2 !== 0 ? 'bg-background' : '' }} hover:bg-background transition-colors">
                    @if(is_array($row))
                        @foreach($row as $cell)
                            <td class="px-4 py-3 text-text-main whitespace-nowrap">{!! $cell !!}</td>
                        @endforeach
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="px-4 py-12">
                        <x-data.empty-state title="Tidak ada data" />
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
