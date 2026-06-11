@props(['route', 'activeRoute'])

@php
    $isActive = request()->routeIs($activeRoute ?? $route);

    $activeClasses = 'bg-ef-green/10 text-ef-green shadow-sm shadow-ef-green/5';

    $inactiveClasses = 'text-ef-grey-1 hover:text-ef-green hover:bg-ef-bg-2 hover:translate-x-1';

    $classes = $isActive ? $activeClasses : $inactiveClasses;

    $iconClasses = $isActive ? 'text-ef-green' : 'text-ef-grey-1 group-hover:text-ef-green';
@endphp

<a href="{{ route($route) }}"
    {{ $attributes->merge([
        'class' => 'relative flex items-center px-4 py-3 rounded-2xl font-bold text-[13px] tracking-wide transition-all duration-300 group ' . $classes
    ]) }}>

    @if($isActive)
        <div class="absolute left-0 w-1 h-5 bg-ef-green rounded-r-full"></div>
    @endif

    <div class="{{ $iconClasses }} mr-3.5 transition-all duration-300 transform group-hover:scale-110">
        {{ $icon }}
    </div>

    <span class="truncate">{{ $slot }}</span>

    <div class="ml-auto opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
        </svg>
    </div>
</a>
