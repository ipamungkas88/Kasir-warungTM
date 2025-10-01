@props(['href', 'current' => false])
@php
  $classes = $current
      ? 'bg-gray-900 dark:bg-gray-950/50 text-white'
      : 'text-gray-300 hover:bg-white/5 hover:text-white';
@endphp
<a href="{{ $href }}"
  {{ $attributes->merge(['class' => ' rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white ' . $classes]) }}>{{ $slot }}
</a>
