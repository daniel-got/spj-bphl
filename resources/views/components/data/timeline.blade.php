@props([
    'events' => [],
    // event: ['title', 'description' => null, 'time', 'icon' => null, 'color' => 'gray']
])

<div {{ $attributes->merge(['class' => 'flow-root']) }}>
    <ul class="-mb-8">
        @foreach($events as $event)
            <li>
                <div class="relative pb-8">
                    @if(!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    @endif
                    <div class="relative flex space-x-3">
                        <div class="flex-shrink-0">
                            <span class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center ring-4 ring-white">
                                @if(isset($event['icon']))
                                    <x-utility.icon :name="$event['icon']" class="w-4 h-4 text-gray-500" />
                                @else
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                @endif
                            </span>
                        </div>
                        <div class="flex-1 min-w-0 pt-1.5 flex justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $event['title'] }}</p>
                                @if(isset($event['description']))
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $event['description'] }}</p>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <time class="text-xs text-gray-400 whitespace-nowrap">{{ $event['time'] }}</time>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
