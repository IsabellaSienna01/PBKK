@props(['type' => 'info'])

@php
    $tone = $type === 'success'
        ? 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-100'
        : 'border-blue-200 bg-blue-50 text-blue-900 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-100';
@endphp

<div role="status" {{ $attributes->class(['rounded-xl border px-5 py-4 text-sm font-medium', $tone]) }}>
    {{ $slot }}
</div>
