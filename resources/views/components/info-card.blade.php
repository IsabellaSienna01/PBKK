@props(['title'])

<div {{ $attributes->class(['rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900']) }}>
    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $title }}</dt>
    <dd class="mt-2 font-semibold text-slate-800 dark:text-slate-100">{{ $slot }}</dd>
</div>
