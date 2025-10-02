@props(['href', 'current' => false])
@php
  // Check if this is being used in sidebar context (has flex class)
  $isSidebar = str_contains($attributes->get('class', ''), 'flex');

  if ($isSidebar) {
      $classes = $current
          ? 'bg-gray-50 dark:bg-white/5 text-indigo-600 dark:text-white'
          : 'text-gray-700 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5';
  } else {
      $classes = $current
          ? 'bg-gray-900 dark:bg-gray-950/50 text-white'
          : 'text-gray-300 hover:bg-white/5 hover:text-white';
  }
@endphp
<a href="{{ $href }}"
  {{ $attributes->merge(['class' => ($isSidebar ? '' : 'rounded-md px-3 py-2 text-sm font-medium ') . $classes]) }}>
  {{ $slot }}
</a>
