@props([
    'title'      => 'Aktivitas Terkini',
    'activities' => [],
    // activity: ['label', 'description' => null, 'time', 'icon' => null]
])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border-custom rounded-xl p-6 shadow-sm']) }}>
    <h3 class="text-sm font-semibold text-text-main mb-4">{{ $title }}</h3>

    @if(count($activities))
        <ul class="space-y-4">
            @foreach($activities as $activity)
                <li class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5 w-8 h-8 rounded-full bg-primary-light flex items-center justify-center">
                        @if(isset($activity['icon']))
                            <x-utility.icon :name="$activity['icon']" class="w-4 h-4 text-primary" />
                        @else
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-text-main truncate">{{ $activity['label'] }}</p>
                        @if(isset($activity['description']))
                            <p class="text-xs text-muted mt-0.5">{{ $activity['description'] }}</p>
                        @endif
                    </div>
                    <span class="flex-shrink-0 text-xs text-muted whitespace-nowrap">{{ $activity['time'] }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <x-data.empty-state title="Belum ada aktivitas" class="py-6" />
    @endif
</div>
