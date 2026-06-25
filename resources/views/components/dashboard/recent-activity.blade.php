@props([
    'title'      => 'Aktivitas Terkini',
    'activities' => [],
    // activity: ['label', 'description' => null, 'time', 'icon' => null, 'color' => 'gray']
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm']) }}>
    <h3 class="text-sm font-semibold text-gray-900 mb-4">{{ $title }}</h3>

    @if(count($activities))
        <ul class="space-y-4">
            @foreach($activities as $activity)
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                        @if(isset($activity['icon']))
                            <x-utility.icon :name="$activity['icon']" class="w-4 h-4 text-gray-500" />
                        @else
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['label'] }}</p>
                        @if(isset($activity['description']))
                            <p class="text-xs text-gray-500 mt-0.5">{{ $activity['description'] }}</p>
                        @endif
                    </div>
                    <span class="flex-shrink-0 text-xs text-gray-400 whitespace-nowrap">{{ $activity['time'] }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <x-data.empty-state title="Belum ada aktivitas" class="py-6" />
    @endif
</div>
