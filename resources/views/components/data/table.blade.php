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
                @php
                    $isAssoc = is_array($row) && array_keys($row) !== range(0, count($row) - 1);
                    $cells = $isAssoc ? ($row['cells'] ?? []) : (is_array($row) ? $row : []);
                    $actions = $isAssoc ? ($row['actions'] ?? []) : [];
                @endphp
                <tr class="{{ $striped && $i % 2 !== 0 ? 'bg-background' : '' }} hover:bg-background transition-colors">
                    @foreach($cells as $cell)
                        <td class="px-4 py-3 text-text-main whitespace-nowrap">{!! $cell !!}</td>
                    @endforeach
                    
                    @if(!empty($actions))
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                @foreach($actions as $type => $config)
                                    @if($type === 'raw')
                                        {!! is_array($config) ? ($config['html'] ?? '') : $config !!}
                                        @continue
                                    @endif

                                    @php
                                        $url = is_array($config) ? ($config['url'] ?? '#') : (is_string($config) ? $config : '#');
                                        $onclick = is_array($config) ? ($config['onclick'] ?? '') : '';
                                        
                                        $icon = 'dots-horizontal';
                                        $hoverClass = 'hover:text-text-main hover:bg-gray-100';
                                        $title = ucfirst($type);
                                        
                                        if ($type === 'detail') {
                                            $icon = 'eye';
                                            $hoverClass = 'hover:text-info hover:bg-blue-50';
                                            $title = 'Detail';
                                        } elseif ($type === 'edit') {
                                            $icon = 'pencil';
                                            $hoverClass = 'hover:text-primary hover:bg-primary-light';
                                            $title = 'Edit';
                                        } elseif ($type === 'delete') {
                                            $icon = 'trash';
                                            $hoverClass = 'hover:text-danger hover:bg-red-50';
                                            $title = 'Hapus';
                                        } elseif ($type === 'print') {
                                            $icon = 'printer';
                                            $hoverClass = 'hover:text-gray-700 hover:bg-gray-100';
                                            $title = 'Cetak';
                                        }
                                        $target = ($type === 'print') ? 'target="_blank"' : '';
                                    @endphp
                                    
                                    @if($onclick)
                                        <button type="button" onclick="{{ $onclick }}" class="p-2 text-muted {{ $hoverClass }} rounded-md transition-colors" title="{{ $title }}">
                                            <x-utility.icon name="{{ $icon }}" class="w-4 h-4" />
                                        </button>
                                    @elseif($type === 'delete')
                                        <form action="{{ $url }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-muted {{ $hoverClass }} rounded-md transition-colors" title="{{ $title }}">
                                                <x-utility.icon name="{{ $icon }}" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ $url }}" {!! $target !!} class="p-2 text-muted {{ $hoverClass }} rounded-md transition-colors inline-block" title="{{ $title }}">
                                            <x-utility.icon name="{{ $icon }}" class="w-4 h-4" />
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </td>
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
        {{ $slot }}
    </table>
</div>
