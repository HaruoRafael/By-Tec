@props(['active'])

@php
$defaultClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-yellow-500 dark:text-yellow-500 hover:text-yellow-400 dark:hover:text-yellow-400 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-yellow-400 dark:focus:text-yellow-400 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
$activeClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-white dark:border-white text-white dark:text-white focus:outline-none focus:border-white transition duration-150 ease-in-out';
$classes = ($active ?? false) ? $activeClasses : $defaultClasses;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
